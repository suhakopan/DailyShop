<?php

namespace App\Controller\Admin;

use App\Entity\Admin\Image;
use App\Form\Admin\Image1Type;
use App\Repository\Admin\ImageRepository;
use phpDocumentor\Reflection\Types\Integer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/image")
 */
class ImageController extends AbstractController
{
    /**
     * @Route("/", name="admin_image_index", methods={"GET"})
     */
    public function index(ImageRepository $imageRepository): Response
    {
        return $this->render('admin/image/index.html.twig', [
            'images' => $imageRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new/{pid}", name="admin_image_new", methods={"GET","POST"})
     */
    public function new(Request $request, $pid,ImageRepository $imageRepository): Response
    {
        $imageList = $imageRepository->findBy(
            ['ProductNo' => $pid]
        );

        $image = new Image();
        $form = $this->createForm(Image1Type::class, $image);
        $form->handleRequest($request);

        if ($request->files->get('imageName')) {

            $file=$request->files->get('imageName');
            $fileName = $this->generateUniqueFileName().'.'.$file->guessExtension();
            try{
              $file->move(
                  $this->getParameter('images_directory'),
                  $fileName
              );
            } catch(FileException $e){

            }
            $image->setImageSource($fileName);
            $image->setProductNo($pid);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($image);
            $entityManager->flush();

            return $this->redirectToRoute('admin_image_new',array('pid' => $pid));
        }

        return $this->render('admin/image/new.html.twig', [
            'image' => $image,
            'imageList' => $imageList,
            'pid' => $pid,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin_image_show", methods={"GET"})
     */
    public function show(Image $image): Response
    {
        return $this->render('admin/image/show.html.twig', [
            'image' => $image,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="admin_image_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Image $image): Response
    {
        $form = $this->createForm(Image1Type::class, $image);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_image_index', [
                'id' => $image->getId(),
            ]);
        }

        return $this->render('admin/image/edit.html.twig', [
            'image' => $image,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin_image_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Image $image): Response
    {
        if ($this->isCsrfTokenValid('delete'.$image->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($image);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_image_index');
    }

    /**
     * @Route("/{id}/{pid}", name="admin_image_del", methods={"GET","POST"})
     */
    public function del(Request $request, Image $image,$pid): Response
    {

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($image);
        $entityManager->flush();


        return $this->redirectToRoute('admin_image_new',array('pid' =>$pid));
    }
        /**
     * @return string
     */
    private function generateUniqueFileName()
    {
        return md5(uniqid());
    }



}
