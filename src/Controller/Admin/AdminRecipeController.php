<?php

namespace App\Controller\Admin;

use App\Entity\Recipe;
use App\Form\AdminRecipeType;
use App\Repository\RecipeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AdminRecipeController extends AbstractController
{

    #[Route('/admin/recipes/create', 'admin_create_recipe', methods: ['GET', 'POST'])]
    public function createRecipe(Request $request, EntityManagerInterface $entityManager)
    {
        $recipe = new Recipe();

        $adminRecipeForm = $this->createForm(AdminRecipeType::class, $recipe);

        // le handleRequest récupère les données de POST (donc du form envoyé)
        // pour chaque donnée, il va modifier l'entité (setTitle, setImage etc)
        // et donc remplir l'entité avec les données du form
        $adminRecipeForm->handleRequest($request);

        if ($adminRecipeForm->isSubmitted()) {
            $entityManager->persist($recipe);
            $entityManager->flush();

            $this->addFlash('success', 'Recette enregistrée');
        }

        $adminRecipeFormView = $adminRecipeForm->createView();

        return $this->render('admin/recipe/create_recipe.html.twig', [
            'adminRecipeFormView' => $adminRecipeFormView
        ]);

    }


    #[Route('/admin/recipes/list', 'admin_list_recipes', methods: ['GET'])]
    public function listRecipes(RecipeRepository $recipeRepository) {

        $recipes = $recipeRepository->findAll();

        return $this->render('admin/recipe/list_recipes.html.twig', [
            'recipes' => $recipes
        ]);

    }


}