<?php

namespace App\Controller;

use App\Entity\Suite;
use App\Entity\Reservation;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use App\Form\ReservationType;

class SuiteController extends AbstractController
{
    #[Route('/suite', name: 'app_suite')]
    public function index(ManagerRegistry $doctrine): Response
    {
        $suiteRepository = $doctrine->getRepository(Suite::class);
        $suites =  $suiteRepository->findAll();
        return $this->render('suite/index.html.twig', [
            'controller_name' => 'SuiteController',
            'suites' => $suites
        ]);
    }

    #[Route('/suite/{id}', name: 'suite_details')]
    public function single(Request $request, ManagerRegistry $doctrine, int $id): Response
    {
        $suiteRepository = $doctrine->getRepository(Suite::class);
        $suite = $suiteRepository->find($id);

        $reservation = new Reservation();
        $form = $this->createForm(ReservationType::class, $reservation, [
            // 'available_suites' => $doctrine->getRepository(Suite::class)->findAvailableSuites()
        ]);


        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $selectedSuite = $form->get('suite')->getData();

            $entityManager = $doctrine->getManager();
            $entityManager->persist($selectedSuite);

            $dateDebut = $form->get('DateDebut')->getData();
            $dateFin = $form->get('DateFin')->getData();
            $prix = $selectedSuite->getPrixTotal();
            $reservation->setPrix($prix);

            $entityManager->persist($reservation);
            $entityManager->flush();

            return $this->redirectToRoute('app_reservation_success');
        }

        return $this->render('suite/details.html.twig', [
            'controller_name' => 'SuiteController',
            'suite' => $suite,
            'form' => $form
        ]);
    }

    #[Route('/reservation/success', name: 'app_reservation_success')]
    public function reservationSuccess(): Response
    {
        return $this->render('reservation/success.html.twig');
    }
}
