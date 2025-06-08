<?php

namespace App\Controller;

use App\Entity\Beneficiary;
use App\Entity\Campaign;
use App\Form\CampaignForm;
use App\Enum\CampaignStatus;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class CreateCampaignController extends AbstractController
{
    #[Route('/creer-campagne', name: 'app_create_campaign', methods: ['POST', 'GET'])]
    public function index(Request $request, EntityManagerInterface $em): Response
    {
        $beneficiary = $em->getRepository(Beneficiary::class)->findOneBy(['userAccount' => $this->getUser()]);
        if (!$beneficiary) {
            $this->addFlash('error', 'Vous devez d\'abord créer un compte bénéficiaire.');
            return $this->redirectToRoute('app_beneficiary_create');
        }
        $campaign = new Campaign();
        $form = $this->createForm(CampaignForm::class, $campaign);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $campaign->setUpdatedAt(new \DateTimeImmutable());
            $campaign->setCampaignStatus(CampaignStatus::DRAFT);
            $campaign->setStartDate(new \DateTimeImmutable());

            $campaign->setBeneficiary($beneficiary);
            $campaign->setEndDate(null);

            // Save the campaign to the database
            $em->persist($campaign);
            $em->flush();

            return $this->redirectToRoute('app_account');
        }


        return $this->render('create_campaign/index.html.twig', [
            'form' => $form,
            'campaign' => $campaign,
        ]);
    }
}
