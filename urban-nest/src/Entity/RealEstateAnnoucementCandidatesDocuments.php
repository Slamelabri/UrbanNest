<?php

namespace App\Entity;

use App\Repository\RealEstateAnnoucementCandidatesDocumentsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RealEstateAnnoucementCandidatesDocumentsRepository::class)]
class RealEstateAnnoucementCandidatesDocuments
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'documens')]
    private ?RealEstateAnnoucementCandidates $application = null;

    #[ORM\ManyToOne(inversedBy: 'applicationsDocuments')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $Author = null;

    #[ORM\Column(length: 255)]
    private ?string $document_url = null;

    #[ORM\Column(length: 255)]
    private ?string $document_name = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getApplication(): ?RealEstateAnnoucementCandidates
    {
        return $this->application;
    }

    public function setApplication(?RealEstateAnnoucementCandidates $application): static
    {
        $this->application = $application;

        return $this;
    }

    public function getAuthor(): ?User
    {
        return $this->Author;
    }

    public function setAuthor(?User $Author): static
    {
        $this->Author = $Author;

        return $this;
    }

    public function getDocumentUrl(): ?string
    {
        return $this->document_url;
    }

    public function setDocumentUrl(string $document_url): static
    {
        $this->document_url = $document_url;

        return $this;
    }

    public function getDocumentName(): ?string
    {
        return $this->document_name;
    }

    public function setDocumentName(string $document_name): static
    {
        $this->document_name = $document_name;

        return $this;
    }
}
