<?php

namespace App\Controller;

use App\Entity\Establishment;
use App\Repository\EstablishmentRepository;
use App\Repository\WidgetRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class WidgetController extends AbstractController
{
    #[Route('/widget', name: 'widget')]
    public function index(Request $request, WidgetRepository $widgetRepository): Response
    {
        $establishmentGetParam = $request->query->get('establishment');

        $widgets = $widgetRepository->findBy(['establishement', $establishmentGetParam]);

        dd($widgets);

        return $this->render('widget/index.html.twig', [
            'establishment' => $establishment
        ]);
    }
}
