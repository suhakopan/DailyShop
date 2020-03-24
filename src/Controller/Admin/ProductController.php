<?php

namespace App\Controller\Admin;

use App\Entity\Admin\Product;
use App\Entity\Images;
use App\Form\Admin\ProductType;
use App\Repository\Admin\CategoryRepository;
use App\Repository\Admin\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/product")
 */
class ProductController extends AbstractController
{
    /**
     * @Route("/", name="admin_product_index", methods={"GET"})
     */
    public function index(ProductRepository $productRepository): Response
    {
        return $this->render('admin/product/index.html.twig', [
            'products' => $productRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="admin_product_new", methods={"GET","POST"})
     */
    public function new(Request $request,CategoryRepository $categoryRepository): Response
    {
        $catlist = $categoryRepository->findAll();
        $catname = $categoryRepository->findBy(
            ['id' => 0]
        );
        $product = new Product();
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($product);
            $entityManager->flush();

            return $this->redirectToRoute('admin_product_index');
        }

        return $this->render('admin/product/new.html.twig', [
            'product' => $product,
            'catlist' => $catlist,
            'catname' => $catname,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin_product_show", methods={"GET"})
     */
    public function show(Product $product): Response
    {
        return $this->render('admin/product/show.html.twig', [
            'product' => $product,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="admin_product_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Product $product,CategoryRepository $categoryRepository): Response
    {
        $catlist = $categoryRepository->findAll();
        $catname = $categoryRepository->findBy(
            ['id' => $product->getCategoryNo()]
        );
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_product_index', [
                'id' => $product->getId(),
            ]);
        }

        return $this->render('admin/product/edit.html.twig', [
            'product' => $product,
            'catlist' => $catlist,
            'catname' => $catname,
            'form' => $form->createView(),
        ]);
        $this->addFlash('success','Kayıt Güncelleme Başarılı!');
    }

    /**
     * @Route("/delete/{id}", name="admin_product_delete", methods={"GET","POST"})
     */
    public function delete(Product $product): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($product);
        $entityManager->flush();
        return $this->redirectToRoute('admin_product_index');
    }

}
