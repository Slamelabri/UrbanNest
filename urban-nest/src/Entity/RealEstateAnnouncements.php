<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use App\Repository\RealEstateAnnouncementsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: RealEstateAnnouncementsRepository::class)]
#[ApiResource(
    operations: [
        new Get(
            uriTemplate: '/announcements/g/{id}',
            normalizationContext: ['groups' => 'read'],
        ),
        new GetCollection(
            uriTemplate: '/announcements/list',
            normalizationContext: ['groups' => 'read'],
        ),
    ],
    routePrefix: 'v1',
    order: ['publish_date' => 'DESC']
)]
class RealEstateAnnouncements
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['read'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['read'])]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Groups(['read'])]
    private ?string $description = null;

    #[ORM\Column(length: 255)]
    #[Groups(['read'])]
    private ?string $property_type = null;

    #[ORM\Column]
    #[Groups(['read'])]
    private ?float $price = null;

    #[ORM\Column]
    #[Groups(['read'])]
    private ?float $area = null;

    #[ORM\Column(length: 255)]
    #[Groups(['read'])]
    private ?string $location = null;

    #[ORM\Column]
    #[Groups(['read'])]
    private ?int $bedrooms = null;

    #[ORM\Column]
    #[Groups(['read'])]
    private ?int $bathrooms = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Groups(['read'])]
    private ?\DateTimeInterface $publish_date = null;

    #[ORM\Column]
    #[Groups(['read'])]
    private ?int $status = null;

    #[ORM\ManyToOne(inversedBy: 'realEstateAnnouncements')]
    private ?User $author = null;

    #[ORM\OneToMany(mappedBy: 'announce', targetEntity: RealEstateAnnoucementPictures::class)]
    #[Groups(['read'])]
    private Collection $pictures;

    #[ORM\OneToMany(mappedBy: 'announce', targetEntity: RealEstateAnnoucementCandidates::class)]
    private Collection $applications;

    #[ORM\Column(length: 255)]
    #[Groups(['read'])]
    private ?string $city = null;

    #[ORM\Column(length: 255)]
    #[Groups(['read'])]
    private ?string $postalCode = null;

    #[ORM\Column(length: 255)]
    #[Groups(['read'])]
    private ?string $type = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['read'])]
    private ?string $default_picture = null;

    public function __construct()
    {
        $this->pictures = new ArrayCollection();
        $this->applications = new ArrayCollection();
    }

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

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getPropertyType(): ?string
    {
        return $this->property_type;
    }

    public function setPropertyType(string $property_type): static
    {
        $this->property_type = $property_type;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): static
    {
        $this->price = $price;

        return $this;
    }

    public function getArea(): ?float
    {
        return $this->area;
    }

    public function setArea(float $area): static
    {
        $this->area = $area;

        return $this;
    }

    public function getLocation(): ?string
    {
        return $this->location;
    }

    public function setLocation(string $location): static
    {
        $this->location = $location;

        return $this;
    }

    public function getBedrooms(): ?int
    {
        return $this->bedrooms;
    }

    public function setBedrooms(int $bedrooms): static
    {
        $this->bedrooms = $bedrooms;

        return $this;
    }

    public function getBathrooms(): ?int
    {
        return $this->bathrooms;
    }

    public function setBathrooms(int $bathrooms): static
    {
        $this->bathrooms = $bathrooms;

        return $this;
    }

    public function getPublishDate(): ?\DateTimeInterface
    {
        return $this->publish_date;
    }

    public function setPublishDate(\DateTimeInterface $publish_date): static
    {
        $this->publish_date = $publish_date;

        return $this;
    }

    public function getStatus(): ?int
    {
        return $this->status;
    }

    public function setStatus(int $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getAuthor(): ?User
    {
        return $this->author;
    }

    public function setAuthor(?User $author): static
    {
        $this->author = $author;

        return $this;
    }

    /**
     * @return Collection<int, RealEstateAnnoucementPictures>
     */
    public function getPictures(): Collection
    {
        return $this->pictures;
    }

    public function addPicture(RealEstateAnnoucementPictures $picture): static
    {
        if (!$this->pictures->contains($picture)) {
            $this->pictures->add($picture);
            $picture->setAnnounce($this);
        }

        return $this;
    }

    public function removePicture(RealEstateAnnoucementPictures $picture): static
    {
        if ($this->pictures->removeElement($picture)) {
            // set the owning side to null (unless already changed)
            if ($picture->getAnnounce() === $this) {
                $picture->setAnnounce(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, RealEstateAnnoucementCandidates>
     */
    public function getApplications(): Collection
    {
        return $this->applications;
    }

    public function addApplication(RealEstateAnnoucementCandidates $application): static
    {
        if (!$this->applications->contains($application)) {
            $this->applications->add($application);
            $application->setAnnounce($this);
        }

        return $this;
    }

    public function removeApplication(RealEstateAnnoucementCandidates $application): static
    {
        if ($this->applications->removeElement($application)) {
            // set the owning side to null (unless already changed)
            if ($application->getAnnounce() === $this) {
                $application->setAnnounce(null);
            }
        }

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): static
    {
        $this->city = $city;

        return $this;
    }

    public function getPostalCode(): ?string
    {
        return $this->postalCode;
    }

    public function setPostalCode(string $postalCode): static
    {
        $this->postalCode = $postalCode;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getDefaultPicture(): ?string
    {
        return $this->default_picture;
    }

    public function setDefaultPicture(?string $default_picture): static
    {
        $this->default_picture = $default_picture;

        return $this;
    }
}
