<?php

namespace App\Controller;

use App\Entity\Shopcart;
use App\Form\ShopcartType;
use App\Repository\Admin\CategoryRepository;
use App\Repository\SettingRepository;
use App\Repository\ShopcartRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/shopcart")
 */
class ShopcartController extends AbstractController
{
    /**
     * @Route("/", name="shopcart_index", methods={"GET"})
     */
    public function index(ShopcartRepository $shopcartRepository,SettingRepository $settingRepository): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $user = $this->getUser();

        $em = $this->getDoctrine()->getManager();
        $sql = "SELECT S.id as sid,S.userid,P.id,P.title,P.price,I.image_source,S.quantity FROM product P,image I,shopcart S WHERE s.productid=p.id and I.product_no=p.id and S.userid= :userid GROUP BY p.id";
        $statement = $em->getConnection()->prepare( $sql);
        $statement->bindValue('userid',$user->getid());
        $statement->execute();
        $shopcarts = $statement->fetchAll();


        $data = $settingRepository->findAll();
        $cats = $this->categorytree();
        return $this->render('shopcart/index.html.twig', [
            'shopcarts' =>  $shopcarts,
            'data' => $data,
            'cats' => $cats
        ]);
    }

    /**
     * @Route("/new", name="shopcart_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $shopcart = new Shopcart();
        $form = $this->createForm(ShopcartType::class, $shopcart);
        $form->handleRequest($request);
        $submittedToken = $request->request->get('token');
    if($this->isCsrfTokenValid('add-item', $submittedToken))
    {
        if ($form->isSubmitted()) {
            $entityManager = $this->getDoctrine()->getManager();
            $user = $this->getUser();

            //$shopcart->setQuantity($request->request->get('quantity'));
            $shopcart->setUserid($user->getid());
            $entityManager->persist($shopcart);
            $entityManager->flush();

            return $this->redirectToRoute('shopcart_index');
        }
    }
        return $this->render('shopcart/new.html.twig', [
            'shopcart' => $shopcart,
            //'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="shopcart_show", methods={"GET"})
     */
    public function show(Shopcart $shopcart): Response
    {
        return $this->render('shopcart/show.html.twig', [
            'shopcart' => $shopcart,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="shopcart_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Shopcart $shopcart): Response
    {
        $form = $this->createForm(ShopcartType::class, $shopcart);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('shopcart_index', [
                'id' => $shopcart->getId(),
            ]);
        }

        return $this->render('shopcart/edit.html.twig', [
            'shopcart' => $shopcart,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/delete/{id}", name="shopcart_delete", methods={"GET","POST"})
     */
    public function delete(Shopcart $shopcart): Response
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($shopcart);
        $em->flush();
        return $this->redirectToRoute('shopcart_index');
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
                    //$user_tree_array = $this->categorytree($row['id'],$user_tree_array);
                }
                $user_tree_array[] ="</ul></li>";
            }
            $user_tree_array[] = "</ul></li>";
        }
        return $user_tree_array;
    }
}
