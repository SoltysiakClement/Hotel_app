<?php

namespace App\Controller;

use App\Entity\Messagerie;
use App\Form\ContactFormType;

use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ContactController extends AbstractController
{
    #[Route('/contact', name: 'app_contact')]
    public function add(Request $request, ManagerRegistry $doctrine): Response
    {
        $messagerie = new Messagerie();
        $form = $this->createForm(ContactFormType::class,$messagerie);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form ->isValid()) {
            $messagerie=$form->getData();
           $entityManager = $doctrine->getManager();

           $entityManager->persist($messagerie);
           $entityManager->flush();
        }

        return $this->render('contact/index.html.twig', [
            'controller_name' => 'ContactController',
            'form' => $form,
        ]);
    }
}
