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

        $establishtmentCollection = $widget->getEstablishment();
        $establishtmentFirst = $establishtmentCollection->first();
        $establishtmentId = $establishtmentFirst->getId();
        $isPremium = $establishtmentFirst->getIsPremium();

        $conferencesAll = $conferenceRepository->findByEstablishment($establishtmentId);

        $conferences = $paginator->paginate(
            $conferencesAll,
            $request->query->getInt('page', 1),
            8
        );

        $conferencesNextAll = $conferenceRepository->findFutureConferenceByEstablishment($establishtmentId);
        $conferencesPastAll = $conferenceRepository->findPastConferenceByEstablishment($establishtmentId);

        $conferencesNext = $paginator->paginate(
            $conferencesNextAll,
            $request->query->getInt('page', 1),
            3
        );

        $conferencesPast = $paginator->paginate(
            $conferencesPastAll,
            $request->query->getInt('page', 1),
            8
        );

        return $this->render('widget/index.html.twig', [
            'isValidToken' => $isValidToken,
            'conferencesNext'=> $conferencesNext,
            'conferencesPast'=> $conferencesPast,
            'widget' => $widget,
            'premium' => $isPremium
        ]);
    }
}
