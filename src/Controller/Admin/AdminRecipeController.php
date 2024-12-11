<?php

namespace App\Controller\Admin;

use App\Entity\Recipe;
use App\Form\AdminRecipeType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AdminRecipeController extends AbstractController
{


    #[Route('/admin/recipe/create', 'admin_create_recipe', methods: ['GET', 'POST'])]
    public function createRecipe(Request $request, EntityManagerInterface $entityManager)
    {
        $recipe = new Recipe();

        $adminRecipeForm = $this->createForm(AdminRecipeType::class, $recipe);

        // le handleRequest récupère les données de POST (donc du form envoyé)
        // pour chaque donnée, il va modifier l'entité (setTitle, setImage etc)
        // et donc remplir l'entité avec les données du form
        $adminRecipeForm->handleRequest($request);

        if ($adminRecipeForm->isSubmitted()) {
            $this->addFlash('success', 'Recette enregistrée');
            $entityManager->persist($recipe);
            $entityManager->flush();
        }


        $adminRecipeFormView = $adminRecipeForm->createView();

        return $this->render('admin/recipe/create_recipe.html.twig', [
            'adminRecipeFormView' => $adminRecipeFormView
        ]);

    }

}