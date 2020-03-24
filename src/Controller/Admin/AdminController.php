<?php

namespace App\Controller\Admin;

use App\Entity\Orders;
use App\Repository\OrdersRepository;
//use http\Env\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index()
    {
        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }

    /**
     * @Route("/admin/orders/{slug}", name="admin_orders_index")
     */
    public function orders($slug, OrdersRepository $ordersRepository)
    {
        $orders=$ordersRepository->findBy(['status' => $slug]);

        return $this->render('admin/orders/index.html.twig', [
            'orders' => $orders,
        ]);
    }

    /**
     * @Route("/admin/orders/show/{id}", name="admin_orders_show", methods="GET")
     */
    public function show($id,Orders $orders,OrdersRepository $ordersRepository):Response
    {
        $em = $this->getDoctrine()->getManager();
        $sql = "SELECT p.id,p.Title,p.Price,od.Quantity,(p.Price*od.Quantity) as toplam FROM Orders o,Order_detail od,Product p WHERE o.id=od.order_id and od.product_id=p.id and od.order_id=:orderid";
        $statement = $em->getConnection()->prepare( $sql);
        $statement->bindValue('orderid',$id);
        $statement->execute();
        $orderdetail = $statement->fetchAll();

        return $this->render('admin/orders/show.html.twig', [
            'order' => $orders,
            'orderdetail' => $orderdetail,


        ]);
    }

    /**
     * @Route("/admin/order/{id}/update", name="admin_orders_update", methods={"GET","POST"})
     */
    public function edit(Request $request, Orders $order,$id): Response
    {

        $em = $this->getDoctrine()->getManager();
        $sql = "UPDATE orders SET status=1 WHERE id=:orderid";
        $statement = $em->getConnection()->prepare( $sql);
        $statement->bindValue('orderid',$id);
        $statement->execute();

        return $this->RedirectToRoute('admin_orders_show',array('id' => $id));
    }

}
