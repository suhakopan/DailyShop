<?php

namespace App\Controller;

use App\Repository\SettingRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils,SettingRepository $settingRepository): Response
    {
        $data = $settingRepository->findAll();
        $cats = $this->categorytree();
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error,
            'data' => $data,
            'cats' => $cats
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
                }
                $user_tree_array[] ="</ul></li>";
            }
            $user_tree_array[] = "</ul></li>";
        }
        return $user_tree_array;
    }

    /**
     * @Route("/404", name="app_login_error")
     */
    public function loginerror(AuthenticationUtils $authenticationUtils,SettingRepository $settingRepository): Response
    {
        $data = $settingRepository->findAll();
        $cats = $this->categorytree();
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/404.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error,
            'data' => $data,
            'cats' => $cats
        ]);
    }

}
