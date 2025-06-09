<?php
namespace App\EventListenner;

use App\Entity\Payment;
use Doctrine\ORM\Events;
use App\Enum\PaymentMethod;
use App\Service\MtnMomoService;
use Symfony\Component\Uid\Uuid;
use Doctrine\ORM\Event\PostPersistEventArgs;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsEntityListener;


#[AsEntityListener(event: Events::postPersist, method: 'postPersist', entity: Payment::class)]
class PaymentProcessing
{
    public function __construct(private MtnMomoService $mtnMomoService)
    {
        
    }
    public function postPersist(Payment $payment, PostPersistEventArgs $event): void
    {
        if ($payment->getPaymentMethod() !== PaymentMethod::MTN_MOMO) {
            // If the payment method is not MTN_MOMO, we do not process it
            return;
        }

        $this->mtnMomoService->requestToPay($payment->getAmount(), $payment->getPhoneNumber(), Uuid::v1(), $payment->getTransactionNumber());

    }
}