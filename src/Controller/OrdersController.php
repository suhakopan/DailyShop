<?php

namespace App\Controller;

use App\Entity\OrderDetail;
use App\Entity\Orders;
use App\Form\Orders1Type;
use App\Repository\OrderDetailRepository;
use App\Repository\OrdersRepository;
use App\Repository\SettingRepository;
use App\Repository\ShopcartRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/orders")
 */
class OrdersController extends AbstractController
{
    /**
     * @Route("/", name="orders_index", methods={"GET"})
     */
    public function index(OrdersRepository $ordersRepository,SettingRepository $settingRepository): Response
    {
        $user = $this->getUser();
        $data = $settingRepository->findAll();
        $cats = $this->categorytree();
        $userid = $user->getid();
        return $this->render('orders/index.html.twig', [
            'orders' => $ordersRepository->findBy(['UserID'=>$userid]),
            'data' => $data,
            'cats' => $cats
            ]);
    }

    /**
     * @Route("/new", name="orders_new", methods={"GET","POST"})
     */
    public function new(Request $request,ShopcartRepository $shopcartRepository,SettingRepository $settingRepository): Response
    {
        $data = $settingRepository->findAll();
        $cats = $this->categorytree();
        $orders = new Orders();
        $form = $this->createForm(Orders1Type::class, $orders);
        $form->handleRequest($request);

        $user = $this->getUser();
        $userid = $user->getid();
        $total = $shopcartRepository->getUserShopTotal($userid);
        $tax = $shopcartRepository->getUserShopTax($userid);

        $submittedToken = $request->request->get('token');
        if ($this->isCsrfTokenValid('form-order',$submittedToken)){
            //if ($form->isSubmitted()) {
                $entityManager = $this->getDoctrine()->getManager();

                $orders->setUserid($userid);
                $orders->setTotal($total);
                $orders->setTax($tax);
                $orders->setPaymentType("Kredi Kartı");
                $orders->setStatus(false);
                $entityManager->persist($orders);
                $entityManager->flush();

                $orderid = $orders->getId();
                $shopcart = $shopcartRepository->getUserShopCart($userid);
                foreach ($shopcart as $item){

                    $orderdetail = new OrderDetail();
                    $orderdetail->setOrderID($orderid);
                    $orderdetail->setProductID($item["productid"]);
                    $orderdetail->setQuantity($item["quantity"]);

                    $entityManager->persist($orderdetail);
                    $entityManager->flush();

                }


                $entityManager=$this->getDoctrine()->getManager();
                $query = $entityManager->createQuery('DELETE FROM App\Entity\Shopcart s WHERE s.userid=:userid')->setParameter('userid',$userid);

                $query->execute();
                return $this->redirectToRoute('orders_index');
           // }
        }


        return $this->render('orders/new.html.twig', [
            'order' => $orders,
            'form' => $form->createView(),
            'data' => $data,
            'total' => $total,
            'tax' => $tax,
            'cats' => $cats
        ]);
    }

    /**
     * @Route("/{id}", name="orders_show", methods={"GET"})
     */
    public function show(Orders $order,OrdersRepository $ordersRepository, OrderDetailRepository $orderDetailRepository,SettingRepository $settingRepository): Response
    {
        $data = $settingRepository->findAll();
        $cats = $this->categorytree();
        $orderid = $order->getId();

        $em = $this->getDoctrine()->getManager();
        $sql = "SELECT p.id,p.Title,p.Price,od.Quantity,(p.Price*od.Quantity) as toplam FROM Orders o,Order_detail od,Product p WHERE o.id=od.order_id and od.product_id=p.id and od.order_id=:orderid";
        $statement = $em->getConnection()->prepare( $sql);
        $statement->bindValue('orderid',$orderid);
        $statement->execute();
        $orderdetail = $statement->fetchAll();

        return $this->render('orders/show.html.twig', [
            'order' => $order,
            'orderdetail' => $orderdetail,
            'data' => $data,
            'cats' => $cats

        ]);
    }

    /**
     * @Route("/{id}/edit", name="orders_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Orders $order): Response
    {
        $form = $this->createForm(Orders1Type::class, $order);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('orders_index', [
                'id' => $order->getId(),
            ]);
        }

        return $this->render('orders/edit.html.twig', [
            'order' => $order,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="orders_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Orders $order): Response
    {
        if ($this->isCsrfTokenValid('delete'.$order->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($order);
            $entityManager->flush();
        }

        return $this->redirectToRoute('orders_index');
    }

    public function categorytree($parent = 1, $user_tree_array = '')
    {
        if (!is_array($user_tree_array))
            $user_tree_array = array();

        $em = $this->getDoctrine()->getManager();
        $sql1 = "SELECT * FROM Genders";
        $st1 = $em->getConnection()->prepare($sql1);
        $st1->execute();
        $rs1 = $st1->fetchAll();

        if(count($rs1)>0){
            foreach ($rs1 as $row2)
            {
                $user_tree_array[] = "<li> <a href='#'>".$row2['name']."<span class=\"caret\"></span></a>";
                $user_tree_array[] = "<ul class=\"dropdown-menu\">";
                $sql = "SELECT * FROM  Category WHERE gender_No=".$row2['id'];
                $statement = $em->getConnection()->prepare( $sql);
                $statement->execute();
                $result = $statement->fetchAll();
                foreach ($result as $row){
                    $user_tree_array[] = "<li> <a href='/category/".$row['id']."'>".$row['name']."</a></li>";
                }
                $user_tree_array[] ="</ul></li>";
            }
            $user_tree_array[] = "</ul></li>";
        }
        return $user_tree_array;
    }
}
