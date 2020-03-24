<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Users;
use App\Form\UsersType;
use App\Repository\Admin\CategoryRepository;
use App\Repository\Admin\ProductRepository;
use App\Repository\Admin\ImageRepository;
use App\Repository\SettingRepository;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(SettingRepository $settingRepository,CategoryRepository $categoryRepository)
    {
        $data = $settingRepository->findAll();
        $em = $this->getDoctrine()->getManager();
        $sql = "SELECT P.*,I.* FROM product P,image I WHERE P.id=I.product_no GROUP BY P.ID DESC LIMIT 5";
        $statement = $em->getConnection()->prepare($sql);
        $statement->execute();
        $sliders = $statement->fetchAll();


        $sql2 = 'SELECT P.*,I.image_source FROM product P,image I WHERE P.id=I.product_no GROUP BY P.id';
        $statement2 = $em->getConnection()->prepare($sql2);
        $statement2->execute();
        $products = $statement2->fetchAll();

        $cats = $this->categorytree();
        //print_r($cats);
         //die();

        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'data' => $data,
            'cats' => $cats,
            'sliders' => $sliders,
            'products' => $products
        ]);
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

    /**
     * @Route("/category/{catid}", name="category_products", methods="GET")
     */
    public function CategoryProducts($catid,CategoryRepository $categoryRepository,SettingRepository $settingRepository)
    {
        $data = $settingRepository->findAll();

        $cats = $this->categorytree();
        $data2 = $categoryRepository->findBy(
            ['id' => $catid]
        );
        $em = $this->getDoctrine()->getManager();
        $sql = 'SELECT P.*,I.image_source FROM product P,image I WHERE category_No= :catid and P.id=I.product_no GROUP BY P.id';
        $statement = $em->getConnection()->prepare($sql);
        $statement->bindValue('catid',$catid);
        $statement->execute();
        $products = $statement->fetchAll();
        //dump($result);
        //die();
        return $this->render('home/product.html.twig',[
            'data2' => $data2,
            'products' => $products,
            'cats' => $cats,
            'data' => $data
        ]);
    }


    /**
     * @Route("/product/{id}", name="product_detail", methods="GET")
     */
    public function ProductDetail($id,ProductRepository $productRepository,ImageRepository $imageRepository,SettingRepository $settingRepository)
    {
        $data = $settingRepository->findAll();

        $data2 = $productRepository->findBy(
            ['id' => $id]
        );

        $images = $imageRepository->findBy(
            ['ProductNo' => $id]
        );


        $cats = $this->categorytree();

        return $this->render('home/product_detail.html.twig',[
            'data' => $data,
            'data2' => $data2,
            'cats' => $cats,
            'images' => $images
        ]);
    }

    /**
     * @Route("/register", name="new_user",methods="GET|POST")
     */
    public function newuser(Request $request,SettingRepository $settingRepository,UserRepository $userRepository):Response
    {
        $data = $settingRepository->findAll();
        $cats = $this->categorytree();
        $user = new User();
        $form = $this->createForm(UsersType::class, $user);
        $form->handleRequest($request);
        $submittedToken = $request->request->get('token');
        if ($this->isCsrfTokenValid('register-auth', $submittedToken)) {
            if ($form->isSubmitted()) {
                $emaildata = $userRepository->findBy(['email' =>$user->getEmail()]);
                if(!$emaildata){
                    $em = $this->getDoctrine()->getManager();
                    $em->persist($user);
                    $em->flush();
                    return $this->redirectToRoute('app_login');
                }
                else{
                    $this->addFlash('danger', "Bu mail adresi sistemimizde zaten kayıtlıdır. Lütfen başka bir mail adresi ile deneyiniz");
                    return $this->redirectToRoute('new_user');
                }

            }
        }
        return $this->render('home/register.html.twig', [
            'form' => $form->createView(),
            'data' => $data,
            'cats' => $cats
        ]);
    }

}
