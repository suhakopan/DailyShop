<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Form\UsersType;
use App\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserController extends AbstractController
{
    /**
     * @Route("/admin/user", name="admin_user")
     */
    public function index()
    {
        $users = $this ->getDoctrine()
            ->getRepository(User::class)
            ->findAll();

        return $this->render('admin/user/index.html.twig', [
            'users' => $users,
        ]);
    }

    /**
     * @Route("/admin/user/new", name="admin_user_new",methods="GET|POST")
     */
    public function new(Request $request):Response
    {
        $user= new User();
        $form = $this ->createForm(UserType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
            return $this->redirectToRoute('admin_user');
        }

        return $this->render('admin/user/create_form.html.twig',[
            'form' => $form->createView(),
            ]);
    }


    /**
     * @Route("/admin/user/delete/{id}", name="admin_user_delete",methods="GET|POST")
     */
    public function delete(User $users):Response
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($users);
        $em->flush();
        return $this->redirectToRoute('admin_user');
    }

    /**
     * @Route("/admin/user/edit/{id}", name="admin_user_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, User $user, UserPasswordEncoderInterface $encoder): Response
    {

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
                //dump($user);
                //die();
                $this->addFlash('success','Bilgileriniz başarıyla güncellendi');
                return $this->redirectToRoute('admin_user');
            }
        }

        return $this->render('admin/user/edit_form.html.twig',['user' => $user]);
    }

}
