<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EstablishmentController extends AbstractController
{
    #[Route('/establishment', name: 'establishment')]
    public function index(): Response
    {
        return $this->render('establishment/index.html.twig', [
            'controller_name' => 'EstablishmentController',
        ]);
    }
}
