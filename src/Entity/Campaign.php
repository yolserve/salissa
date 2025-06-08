<?php

namespace App\Entity;

use App\Enum\CampaignStatus;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Vich\UploaderBundle\Entity\File;
use App\Repository\CampaignRepository;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

#[ORM\Entity(repositoryClass: CampaignRepository::class)]
#[Vich\Uploadable]
class Campaign
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $startDate = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTime $endDate = null;

    #[ORM\Column(enumType: CampaignStatus::class)]
    private ?CampaignStatus $campaignStatus = null;

    #[ORM\ManyToOne]
    private ?Category $category = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $coverPictureUrl = null;

    #[Vich\UploadableField(mapping: 'cover_pictures', fileNameProperty: 'coverPictureUrl')]
    private ?File $imageFile = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getStartDate(): ?\DateTimeImmutable
    {
        return $this->startDate;
    }

    public function setStartDate(\DateTimeImmutable $startDate): static
    {
        $this->startDate = $startDate;

        return $this;
    }

    public function getEndDate(): ?\DateTime
    {
        return $this->endDate;
    }

    public function setEndDate(?\DateTime $endDate): static
    {
        $this->endDate = $endDate;

        return $this;
    }

    public function getCampaignStatus(): ?CampaignStatus
    {
        return $this->campaignStatus;
    }

    public function setCampaignStatus(CampaignStatus $campaignStatus): static
    {
        $this->campaignStatus = $campaignStatus;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): static
    {
        $this->category = $category;

        return $this;
    }

    public function getCoverPictureUrl(): ?string
    {
        return $this->coverPictureUrl;
    }

    public function setCoverPictureUrl(?string $coverPictureUrl): static
    {
        $this->coverPictureUrl = $coverPictureUrl;

        return $this;
    }
}
