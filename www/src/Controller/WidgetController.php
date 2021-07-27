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
        $tokenGetParam = $request->query->get('token');
        $widgetIdGetParam = $request->query->get('id');
        $widget = $widgetRepository->find($widgetIdGetParam);
        $isValidToken = ($tokenGetParam === $widget->getToken());

        return $this->render('widget/index.html.twig', [
            'isValidToken' => $isValidToken,
            'widget' => $widget
        ]);
    }
}
