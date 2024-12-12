<?php

namespace App\Controller\Public;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class LoginController extends AbstractController
{

    #[Route('/login', 'login')]
    public function login(AuthenticationUtils $authenticationUtils)
    {

        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('public/login.html.twig', [
            'error' => $error,
            'lastUsername' => $lastUsername
        ]);

    }

    #[Route('/admin/logout', 'logout')]
    public function logout()
    {
        // cette route est utilisée par symfony
        // dans le security.yaml
        // pour gérer la deconnexion
    }

}
