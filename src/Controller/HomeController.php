<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{


    #[Route('/', 'homepage', methods: ['GET'])]
    public function showHomePage() {

        return $this->render('homepage.html.twig');

    }

}