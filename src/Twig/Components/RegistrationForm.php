<?php

namespace App\Twig\Components;

use App\Form\BeneficiaryForm;
use Symfony\Component\DomCrawler\Form;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\UX\LiveComponent\DefaultActionTrait;
use Symfony\UX\LiveComponent\ComponentWithFormTrait;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[AsLiveComponent]
final class RegistrationForm extends AbstractController
{
    use DefaultActionTrait;
    use ComponentWithFormTrait;
    public function instantiateForm(): FormInterface
    {
       return $this->createForm(BeneficiaryForm::class);
    }

}
