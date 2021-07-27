<?php

namespace App\Controller;

use App\Entity\Conference;
use App\Entity\Establishment;
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

        /*

         $allConferences = $conferenceRepository->findBy([
            // 'establishment_id' => 221
        ]);
        */

        $form = $this->createFormBuilder($conferenceRepository)->getForm();

        return $this->render('conference/index.html.twig', [
            'controller_name' => 'ConferenceController',
            'form' => $form->createView(),
            'conferences' => $allConferences,
        ]);
    }

    #[Route('/conference/establishment/{id}', name: 'conference_establishment')]
    public function searchByEstablishment(ConferenceRepository $conferenceRepository, Establishment $establishment): Response
    {
        $conferences = $conferenceRepository->findConferenceByEstablishment($establishment);

        return $this->render('conference/index.html.twig', [
            'controller_name' => 'ConferenceController',
            'conferences' => $conferences,
        ]);
    }
}
