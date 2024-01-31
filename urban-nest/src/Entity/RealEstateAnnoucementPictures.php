<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use App\Repository\RealEstateAnnoucementPicturesRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RealEstateAnnoucementPicturesRepository::class)]
#[ApiResource(
    operations: [
        new Get(
            uriTemplate: '/announcements/pictures/{id}',
        ),
        new GetCollection(
            uriTemplate: '/announcements/pictures',
        )
    ],
    routePrefix: 'v1',
)]
class RealEstateAnnoucementPictures
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'pictures')]
    private ?RealEstateAnnouncements $announce = null;

    #[ORM\Column(length: 255)]
    private ?string $picture_url = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAnnounce(): ?RealEstateAnnouncements
    {
        return $this->announce;
    }

    public function setAnnounce(?RealEstateAnnouncements $announce): static
    {
        $this->announce = $announce;

        return $this;
    }

    public function getPictureUrl(): ?string
    {
        return $this->picture_url;
    }

    public function setPictureUrl(string $picture_url): static
    {
        $this->picture_url = $picture_url;

        return $this;
    }
}
