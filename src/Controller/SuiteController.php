<?php

namespace App\Controller;

use App\Entity\Suite;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

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
}
