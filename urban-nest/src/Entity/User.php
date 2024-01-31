<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    private ?string $email = null;

    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\Column(length: 255)]
    private ?string $surname = null;

    #[ORM\Column(length: 255)]
    private ?string $firstName = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $phone = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $adress = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $city = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $state = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $postalCode = null;

    #[ORM\OneToMany(mappedBy: 'author', targetEntity: RealEstateAnnouncements::class)]
    private Collection $realEstateAnnouncements;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: RealEstateAnnoucementCandidates::class)]
    private Collection $applications;

    #[ORM\OneToMany(mappedBy: 'Author', targetEntity: RealEstateAnnoucementCandidatesDocuments::class, orphanRemoval: true)]
    private Collection $applicationsDocuments;

    #[ORM\Column(type: 'boolean')]
    private $isVerified = false;

    public function __construct()
    {
        $this->realEstateAnnouncements = new ArrayCollection();
        $this->applications = new ArrayCollection();
        $this->applicationsDocuments = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getSurname(): ?string
    {
        return $this->surname;
    }

    public function setSurname(string $surname): static
    {
        $this->surname = $surname;

        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): static
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): static
    {
        $this->phone = $phone;

        return $this;
    }

    public function getAdress(): ?string
    {
        return $this->adress;
    }

    public function setAdress(?string $adress): static
    {
        $this->adress = $adress;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(?string $city): static
    {
        $this->city = $city;

        return $this;
    }

    public function getState(): ?string
    {
        return $this->state;
    }

    public function setState(?string $state): static
    {
        $this->state = $state;

        return $this;
    }

    public function getPostalCode(): ?string
    {
        return $this->postalCode;
    }

    public function setPostalCode(?string $postalCode): static
    {
        $this->postalCode = $postalCode;

        return $this;
    }

    /**
     * @return Collection<int, RealEstateAnnouncements>
     */
    public function getRealEstateAnnouncements(): Collection
    {
        return $this->realEstateAnnouncements;
    }

    public function addRealEstateAnnouncement(RealEstateAnnouncements $realEstateAnnouncement): static
    {
        if (!$this->realEstateAnnouncements->contains($realEstateAnnouncement)) {
            $this->realEstateAnnouncements->add($realEstateAnnouncement);
            $realEstateAnnouncement->setAuthor($this);
        }

        return $this;
    }

    public function removeRealEstateAnnouncement(RealEstateAnnouncements $realEstateAnnouncement): static
    {
        if ($this->realEstateAnnouncements->removeElement($realEstateAnnouncement)) {
            // set the owning side to null (unless already changed)
            if ($realEstateAnnouncement->getAuthor() === $this) {
                $realEstateAnnouncement->setAuthor(null);
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
            $application->setUser($this);
        }

        return $this;
    }

    public function removeApplication(RealEstateAnnoucementCandidates $application): static
    {
        if ($this->applications->removeElement($application)) {
            // set the owning side to null (unless already changed)
            if ($application->getUser() === $this) {
                $application->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, RealEstateAnnoucementCandidatesDocuments>
     */
    public function getApplicationsDocuments(): Collection
    {
        return $this->applicationsDocuments;
    }

    public function addApplicationsDocument(RealEstateAnnoucementCandidatesDocuments $applicationsDocument): static
    {
        if (!$this->applicationsDocuments->contains($applicationsDocument)) {
            $this->applicationsDocuments->add($applicationsDocument);
            $applicationsDocument->setAuthor($this);
        }

        return $this;
    }

    public function removeApplicationsDocument(RealEstateAnnoucementCandidatesDocuments $applicationsDocument): static
    {
        if ($this->applicationsDocuments->removeElement($applicationsDocument)) {
            // set the owning side to null (unless already changed)
            if ($applicationsDocument->getAuthor() === $this) {
                $applicationsDocument->setAuthor(null);
            }
        }

        return $this;
    }

    public function isVerified(): bool
    {
        return $this->isVerified;
    }

    public function setIsVerified(bool $isVerified): static
    {
        $this->isVerified = $isVerified;

        return $this;
    }
}
