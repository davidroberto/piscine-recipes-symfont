<?php

namespace App\Controller\Public;

use App\Repository\RecipeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Service\Attribute\Required;

class PublicRecipeController extends AbstractController
{
    #[Route('/recipes', 'list_recipes', methods: ['GET'])]
    public function listPublishedRecipes(RecipeRepository $recipeRepository)
    {
        $publishedRecipes = $recipeRepository->findBy(['isPublished' => true]);

        return $this->render('public/recipe/list_recipe.html.twig', [
            'publishedRecipes' => $publishedRecipes
        ]);

    }

    #[Route('/recipes/{id}', 'show_recipe', requirements: ['id' => '\d+'], methods: ['GET'])]
    public function showRecipe(int $id, RecipeRepository $recipeRepository) {

        $recipe = $recipeRepository->find($id);

        if (!$recipe || !$recipe->isPublished()) {
            $notFoundResponse = new Response('Recette non trouvée', 404);
            return $notFoundResponse;
        }

        return $this->render('public/recipe/show_recipe.html.twig', [
            'recipe' => $recipe
        ]);
    }


    #[Route('recipes/search', 'search_recipes', methods: ['GET'])]
    public function searchRecipes(Request $request, RecipeRepository $recipeRepository)
    {
        $search = $request->query->get('search');

        $recipes = $recipeRepository->findBySearchInTitle($search);

        return $this->render('public/recipe/search_recipe.html.twig', [
            "recipes" => $recipes,
            'search' => $search
        ]);
    }

}