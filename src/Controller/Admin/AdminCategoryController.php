<?php

namespace App\Controller\Admin;

use App\Entity\Category;
use App\Form\CategoryType;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminCategoryController extends AbstractController
{

    #[Route('admin/category/create', 'admin_create_category', methods: ['GET', 'POST'])]
    public function createCategory(Request $request, EntityManagerInterface $entityManager)
    {
        $category = new Category();

        $categoryForm = $this->createForm(CategoryType::class, $category);

        $categoryForm->handleRequest($request);

        if ($categoryForm->isSubmitted() && $categoryForm->isValid()) {

            $entityManager->persist($category);
            $entityManager->flush();
            $this->addFlash('success', 'catégorie créée');

            return $this->redirectToRoute('admin_list_categories');
        }

        $categoryFormView = $categoryForm->createView();

        return $this->render('admin/category/create.html.twig', [
            'categoryFormView' => $categoryFormView
        ]);

    }

    #[Route('admin/category/{id}/update', 'admin_update_category', requirements: ['id' => '\d+'], methods: ['GET', 'POST'])]
    public function updateCategory(int $id, Request $request, EntityManagerInterface $entityManager, CategoryRepository $categoryRepository)
    {
        $category = $categoryRepository->find($id);

        $categoryForm = $this->createForm(CategoryType::class, $category);

        $categoryForm->handleRequest($request);

        if ($categoryForm->isSubmitted() && $categoryForm->isValid()) {

            $entityManager->persist($category);
            $entityManager->flush();
            $this->addFlash('success', 'catégorie mise à jour');

            return $this->redirectToRoute('admin_list_categories');
        }

        $categoryFormView = $categoryForm->createView();

        return $this->render('admin/category/create.html.twig', [
            'categoryFormView' => $categoryFormView
        ]);

    }

    #[Route('admin/category', 'admin_list_categories', methods: ['GET'])]
    public function listCategories(CategoryRepository $categoryRepository)
    {
        $categories = $categoryRepository->findAll();

        return $this->render('admin/category/list.html.twig', [
            'categories' => $categories
        ]);
    }

    #[Route('admin/category/{id}/delete', 'admin_delete_category', requirements: ['id' => '\d+'], methods: ['GET'])]
    public function deleteCategory(int $id, CategoryRepository $categoryRepository, EntityManagerInterface $entityManager)
    {
        $category = $categoryRepository->find($id);


        if (!$category) {
            return new Response('pas de catégorie', 404);
        }


        $entityManager->remove($category);
        $entityManager->flush();
        $this->addFlash('success', "Supprimé");

        return $this->redirectToRoute('admin_list_categories');
    }

}