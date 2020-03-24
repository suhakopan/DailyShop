<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use App\Repository\ContactRepository;
use App\Repository\SettingRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/contact")
 */
class ContactController extends AbstractController
{
    /**
     * @Route("/", name="contact_index", methods={"GET"})
     */
    public function index(ContactRepository $contactRepository): Response
    {

        return $this->render('contact/index.html.twig', [
            'contacts' => $contactRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="contact_new", methods={"GET","POST"})
     */
    public function new(Request $request,SettingRepository $settingRepository): Response
    {
        $cats = $this->categorytree();
        $data = $settingRepository->findAll();
        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($contact);
            $entityManager->flush();
            $this->addFlash('success','Mesajınız bize ulaşmıştır. 10 gün içince e-postanıza dönüş yapılacaktır');
            return $this->redirectToRoute('contact_new');
        }

        return $this->render('contact/new.html.twig', [
            'contact' => $contact,
            'form' => $form->createView(),
            'data' => $data,
            'cats' => $cats
        ]);
    }

    /**
     * @Route("/admin/contact", name="admin_contact")
     */
    public function admincontact()
    {
        $contacts = $this ->getDoctrine()
            ->getRepository(Contact::class)
            ->findAll();

        return $this->render('contact/show.html.twig', [
            'contacts' => $contacts,
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
     * @Route("/{id}/edit", name="contact_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Contact $contact): Response
    {
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('contact_index', [
                'id' => $contact->getId(),
            ]);
        }

        return $this->render('contact/edit.html.twig', [
            'contact' => $contact,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="contact_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Contact $contact): Response
    {
        if ($this->isCsrfTokenValid('delete'.$contact->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($contact);
            $entityManager->flush();
        }

        return $this->redirectToRoute('contact_index');
    }
}
