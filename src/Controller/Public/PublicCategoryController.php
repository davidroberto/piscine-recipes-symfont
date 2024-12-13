<?php

namespace App\Controller\Public;

use App\Repository\CategoryRepository;
use App\Repository\RecipeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Service\Attribute\Required;

class PublicCategoryController extends AbstractController
{
    #[Route('/categories', 'list_categories', methods: ['GET'])]
    public function listCategories(CategoryRepository $categoryRepository)
    {
        $categories = $categoryRepository->findAll();

        return $this->render('public/category/list_category.html.twig', [
            'categories' => $categories
        ]);

    }

    #[Route('/categories/{id}', 'show_category', requirements: ['id' => '\d+'], methods: ['GET'])]
    public function showCategory(int $id, CategoryRepository $categoryRepository) {

        $category = $categoryRepository->find($id);

        if (!$category) {
            $notFoundResponse = new Response('catégorie non trouvée', 404);
            return $notFoundResponse;
        }

        return $this->render('public/category/show_category.html.twig', [
            'category' => $category
        ]);
    }

}