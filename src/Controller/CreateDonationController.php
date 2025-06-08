<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class CreateDonationController extends AbstractController
{
    #[Route('/create/donation', name: 'app_create_donation')]
    public function index(): Response
    {
        return $this->render('create_donation/index.html.twig', [
            'controller_name' => 'CreateDonationController',
        ]);
    }
}
