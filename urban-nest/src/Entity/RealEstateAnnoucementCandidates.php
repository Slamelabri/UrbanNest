<?php

namespace App\Entity;

use App\Repository\RealEstateAnnoucementCandidatesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RealEstateAnnoucementCandidatesRepository::class)]
class RealEstateAnnoucementCandidates
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'applications')]
    private ?User $user = null;

    #[ORM\ManyToOne(inversedBy: 'applications')]
    private ?RealEstateAnnouncements $announce = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $application_date = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $message = null;

    #[ORM\Column]
    private ?int $status = null;

    #[ORM\OneToMany(mappedBy: 'application', targetEntity: RealEstateAnnoucementCandidatesDocuments::class)]
    private Collection $documents;

    public function __construct()
    {
        $this->documents = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
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

    public function getApplicationDate(): ?\DateTimeInterface
    {
        return $this->application_date;
    }

    public function setApplicationDate(\DateTimeInterface $application_date): static
    {
        $this->application_date = $application_date;

        return $this;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(string $message): static
    {
        $this->message = $message;

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

    /**
     * @return Collection<int, RealEstateAnnoucementCandidatesDocuments>
     */
    public function getDocuments(): Collection
    {
        return $this->documents;
    }

    public function addDocuments(RealEstateAnnoucementCandidatesDocuments $documents): static
    {
        if (!$this->documents->contains($documents)) {
            $this->documents->add($documents);
            $documents->setApplication($this);
        }

        return $this;
    }

    public function removeDocuments(RealEstateAnnoucementCandidatesDocuments $documents): static
    {
        if ($this->documents->removeElement($documents)) {
            // set the owning side to null (unless already changed)
            if ($documents->getApplication() === $this) {
                $documents->setApplication(null);
            }
        }

        return $this;
    }
}
