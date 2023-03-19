<?php

namespace App\Controller\Gerant;

use App\Entity\Suite;
use App\Entity\Etablissement;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;

class DashboardController extends AbstractDashboardController
{
    #[Route('/gerant', name: 'gerant')]
    public function index(): Response
    {
        return $this->render('gerant/index.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Hotel App');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToCrud('Etablissement', 'fas fa-bars', Etablissement::class);
        yield MenuItem::linkToCrud('Suite', 'fas fa-list', Suite::class);
    }
}
