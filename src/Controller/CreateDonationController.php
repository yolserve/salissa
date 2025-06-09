<?php

namespace App\Controller;

use App\Entity\Campaign;
use App\Entity\Donation;
use App\Enum\PaymentStatus;
use App\Form\DonationForm;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Uid\Uuid;

final class CreateDonationController extends AbstractController
{
    #[Route('/faire-un-don/{id}', name: 'app_create_donation')]
    public function index(Campaign $campaign, Request $request, EntityManagerInterface $em): Response
    {
        $donation = new Donation();

        $form = $this->createForm(DonationForm::class, $donation);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $donation->setCampaign($campaign);
            $donation->getPayment()->setTransactionNumber(Uuid::v4());
            $donation->getPayment()->setPaymentDate(new \DateTime());
            $donation->getPayment()->setAmount($donation->getAmount());
            $donation->getPayment()->setPaymentStatus(PaymentStatus::PENDING); // Assuming 'paid' is a valid status
            $donation->getPayment()->setTransactionNumber(Uuid::v4());
            $donation->setDonationDate(new \DateTimeImmutable());

            $em->persist($donation);
            $em->flush();

            // Redirect to a success page or the campaign page
            return $this->redirectToRoute('app_show_campaign', ['id' => $campaign->getId()]);
        }


        return $this->render('create_donation/index.html.twig', [
            'campaign' => $campaign,
            'form'=> $form,
        ]);
    }
}
