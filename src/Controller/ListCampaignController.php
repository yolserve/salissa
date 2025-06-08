<?php

namespace App\Controller;

use App\Repository\CampaignRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ListCampaignController extends AbstractController
{
    #[Route('/cagnottes', name: 'app_list_campaign')]
    public function index(CampaignRepository $campaignRepository): Response
    {
        return $this->render('list_campaign/index.html.twig', [
            'campaigns' => $campaignRepository->findAll(),
        ]);
    }
}
