<?php

namespace App\Controller;

use App\Entity\Establishment;
use App\Repository\ConferenceRepository;
use App\Repository\EstablishmentRepository;
use App\Repository\WidgetRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class WidgetController extends AbstractController
{
    #[Route('/widget', name: 'widget')]
    public function index(Request $request, ConferenceRepository $conferenceRepository, WidgetRepository $widgetRepository, PaginatorInterface $paginator): Response
    {

        $tokenGetParam = $request->query->get('token');
        $widgetIdGetParam = $request->query->get('id');
        $widget = $widgetRepository->find($widgetIdGetParam);
        $isValidToken = ($tokenGetParam === $widget->getToken());
        /*
        $establishment = $widget->getEstablishment();


        $conferencesSelected = $conferenceRepository->findBy(['establishment' => $establishment]);

        $conferences = $paginator->paginate(
            $conferencesSelected,
            $request->query->getInt('page', 1),
            8
        );
        */
        $conferences = $conferenceRepository->findByEstablishment(635);

        return $this->render('widget/index.html.twig', [
            'isValidToken' => $isValidToken,
            'conferences' => $conferences,
            'widget' => $widget
        ]);
    }
}
