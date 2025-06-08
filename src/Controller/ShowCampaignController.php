<?php

namespace App\Controller;

use App\Entity\Campaign;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ShowCampaignController extends AbstractController
{
    #[Route('/cagnotte/{id}', name: 'app_show_campaign')]
    public function index(Campaign $campaign): Response
    {
        return $this->render('show_campaign/index.html.twig', [
            'campaign'=> $campaign
        ]);
    }
}
