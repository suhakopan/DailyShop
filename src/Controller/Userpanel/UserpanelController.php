<?php

namespace App\Controller\Userpanel;

use App\Entity\User;
use App\Repository\SettingRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class UserpanelController extends AbstractController
{
    /**
     * @Route("userpanel/", name="userpanel")
     */
    public function index(SettingRepository $settingRepository)
    {
        $data = $settingRepository->findAll();
        $cats = $this->categorytree();
        return $this->render('userpanel/index.html.twig',[
            'data' => $data,
            'cats' => $cats,
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
     * @Route("userpanel/show", name="userpanel_show", methods="GET")
     */
    public function show(SettingRepository $settingRepository)
    {
        $data = $settingRepository->findAll();
        $cats = $this->categorytree();
        return $this->render('userpanel/show.html.twig',[
            'data' => $data,
            'cats' => $cats,
            ]);
    }

    /**
     * @Route("userpanel/edit", name="userpanel_edit", methods={"GET","POST"})
     */
    public function edit(Request $request): Response
    {
        $usersession=$this->getUser();
        $user = $this->getDoctrine()
            ->getRepository(User::class)->find($usersession->getid());
        //dump($user);
        //die();
        if($request->isMethod('POST'))
        {
            $submittedToken = $request->request->get('token');
            if($this->isCsrfTokenValid('user-editing',$submittedToken))
            {
                $user->setName($request->request->get("name"));
                $user->setAddress($request->request->get("address"));
                $user->setCity($request->request->get("city"));
                $user->setPhone($request->request->get("phone"));
                $this->getDoctrine()->getManager()->flush();

                $this->addFlash('success','Bilgileriniz başarıyla güncellendi');
                return $this->redirectToRoute('userpanel');
            }
        }

        return $this->render('userpanel/index.html.twig',['user' => $user]);
    }


}
