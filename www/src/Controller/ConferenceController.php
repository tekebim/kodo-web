<?php

namespace App\Controller;

use App\Entity\Conference;
use App\Form\ConferenceType;

use App\Repository\ConferenceRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ConferenceController extends AbstractController
{
    #[Route('/conference', name: 'conference_index')]
    public function index(ConferenceRepository $conferenceRepository): Response
    {

        $allConferences = $conferenceRepository->findAll();

        $form = $this->createFormBuilder($conferenceRepository)->getForm();
        $conferences = $conferenceRepository->findAll();

        return $this->render('conference/index.html.twig', [
            'controller_name' => 'ConferenceController',
            'form' => $form->createView(),
            'conferences' => $allConferences,
        ]);
    }
}
