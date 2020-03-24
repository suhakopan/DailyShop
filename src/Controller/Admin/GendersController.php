<?php

namespace App\Controller\Admin;

use App\Entity\Admin\Genders;
use App\Form\Admin\GendersType;
use App\Repository\Admin\GendersRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/genders")
 */
class GendersController extends AbstractController
{
    /**
     * @Route("/", name="admin_genders_index", methods={"GET"})
     */
    public function index(GendersRepository $gendersRepository): Response
    {
        return $this->render('admin/genders/index.html.twig', [
            'genders' => $gendersRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="admin_genders_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $gender = new Genders();
        $form = $this->createForm(GendersType::class, $gender);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($gender);
            $entityManager->flush();

            return $this->redirectToRoute('admin_genders_index');
        }

        return $this->render('admin/genders/new.html.twig', [
            'gender' => $gender,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin_genders_show", methods={"GET"})
     */
    public function show(Genders $gender): Response
    {
        return $this->render('admin/genders/show.html.twig', [
            'gender' => $gender,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="admin_genders_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Genders $gender): Response
    {
        $form = $this->createForm(GendersType::class, $gender);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_genders_index', [
                'id' => $gender->getId(),
            ]);
        }

        return $this->render('admin/genders/edit.html.twig', [
            'gender' => $gender,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin_genders_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Genders $gender): Response
    {
        if ($this->isCsrfTokenValid('delete'.$gender->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($gender);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_genders_index');
    }
}
