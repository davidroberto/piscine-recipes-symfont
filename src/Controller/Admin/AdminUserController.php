<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\PasswordHasher\PasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class AdminUserController extends AbstractController
{
    #[Route('/admin/logout', 'logout', methods: ['GET'])]
    public function logout()
    {
        // cette route est utilisée par symfony
        // dans le security.yaml
        // pour gérer la deconnexion
    }


    #[Route('/admin/users', 'admin_list_user',  methods: ['GET'])]
    public function listUser(UserRepository $userRepository) {

        $users = $userRepository->findAll();


        return $this->render('admin/user/list.html.twig', [
            'users' => $users
        ]);

    }

    #[Route('/admin/users/create', 'admin_create_user',  methods: ['GET', 'POST'])]
    public function createUser(Request $request, EntityManagerInterface $entityManager, UserPasswordHasherInterface $userPasswordHasher) {

        $user = new User();

        $userForm = $this->createForm(UserType::class, $user);

        $userForm->handleRequest($request);

        if ($userForm->isSubmitted() && $userForm->isValid()) {


            $clearPassword = $userForm->get('password')->getData();

            $hashedPassword = $userPasswordHasher->hashPassword($user, $clearPassword);

            $user->setPassword($hashedPassword);

            $entityManager->persist($user);
            $entityManager->flush();

            $this->addFlash('success', 'Utilisateur créé');
        }

        $userFormView = $userForm->createView();

        return $this->render('admin/user/create.html.twig', [
            'userFormView' => $userFormView
        ]);

    }



    #[Route('/admin/users/{id}/delete', 'admin_delete_user', requirements: ['id' => '\d+']  ,methods: ['GET'])]
    public function deleteUser(int $id, UserRepository $userRepository, EntityManagerInterface $entityManager)
    {

        $userToDelete = $userRepository->find($id);
        $authenticatedUser = $this->getUser();

        if ($id === $authenticatedUser->getId()) {
            $this->addFlash('error', 'Vous ne pouvez pas supprimer l\'utilisateur connecté. C\'est complément con');

            return $this->redirectToRoute('admin_list_user');
        }

        $entityManager->remove($userToDelete);
        $entityManager->flush();

        $this->addFlash('success', 'utilisateur supprimé !');

        return $this->redirectToRoute('admin_list_user');
    }
}