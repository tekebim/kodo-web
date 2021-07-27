<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class WidgetController extends AbstractController
{
    #[Route('/widget', name: 'widget')]
    public function index(Request $request): Response
    {
        $establishment = $request->query->get('establishment_id');

        return $this->render('widget/index.html.twig', [
            'establishment' => $establishment
        ]);
    }
}
