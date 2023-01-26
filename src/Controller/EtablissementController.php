<?php

namespace App\Controller;

use App\Entity\Etablissement;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class EtablissementController extends AbstractController
{
    #[Route('/etablissements', name: 'app_etablissement')]
    public function index(ManagerRegistry $doctrine): Response
    {
        $etablissementRepository = $doctrine->getRepository(Etablissement::class);
        $etablissements =  $etablissementRepository->findAll();
        return $this->render('etablissement/index.html.twig', [
            'controller_name' => 'EtablissementController',
            'etablissements' => $etablissements
        ]);
    }
    #[Route('/etablissements/{id}', name: 'etablissement_details')]
    public function single(ManagerRegistry $doctrine,int $id): Response
    {
        $etablissementRepository = $doctrine->getRepository(Etablissement::class);
        $etablissement =  $etablissementRepository->find($id);

        return $this->render('etablissement/details.html.twig', [
            'controller_name' => 'EtablissementController',
            'etablissement' => $etablissement
        ]);
}
}