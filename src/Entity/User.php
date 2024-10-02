<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[UniqueEntity(fields: ['email'], message: 'Cette email est déja utilisé')]
#[UniqueEntity(fields: ['no_adeli'], message: 'Ce numero Adeli est déja uttilisé')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    //Annotation/Attribut php8
    #[ORM\Id] //Signifie que c'est la cle primaire
    #[ORM\GeneratedValue] // L'id sera en auto increment
    #[ORM\Column] //Colonne id
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    #[Assert\NotBlank(message: "Veuillez saisir une adresse email.")]
    #[Assert\Length(
        min: 3,
        max: 180,
        minMessage: 'Votre email doit avoir au moins {{ limit }} caracteres',
        maxMessage: 'Votre email ne doit pas depasser {{ limit }} caracteres',
    )]
    #[Assert\Email(message: 'Cette adresse email n\'est pas valide')]
    private ?string $email = null;

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\Column(length: 50, type: 'string')]

    #[Assert\Length(
        min: 3,
        max: 50,
        minMessage: 'Votre nom doit avoir au moins {{ limit }} caracteres',
        maxMessage: 'Votre nom ne doit pas depasser {{ limit }} caracteres',
    )]
    private ?string $last_name;


    #[ORM\Column(length: 50)]
    #[Assert\NotBlank(
        message: 'Veuillez saisir un  nom '
    )]

    #[Assert\Length(
        min: 3,
        max: 50,
        minMessage: 'Votre prenom doit avoir au moins {{ limit }} caracteres',
        maxMessage: 'Votre prénom ne doit pas depasser {{ limit }} caracteres',
    )]
    private ?string $name;

    #[ORM\Column(length: 50)]
    #[Assert\NotBlank(message: 'Le numéro de téléphone ne peut pas être vide')]
    #[Assert\Regex(
        pattern: '/^[0-9]{10}$/',
        message: 'Le numéro de téléphone doit contenir 10 chiffres'
    )]
    private ?string $phone = null;

    #[ORM\Column(unique: true)]
    #[Assert\NotBlank(message: 'Veuillez saisir un numéro Adeli')]
    #[Assert\Positive(message: 'Le numéro Adeli doit être un entier positif')]


    private ?int $no_adeli = null;


    #[ORM\Column(length: 50, nullable: true)]
    #[Assert\NotBlank(message: 'L\'adresse ne peut pas être vide')]
    #[Assert\Length(
        min: 10,
        max: 100,
        minMessage: 'L\'adresse doit avoir au moins {{ limit }} caractères',
        maxMessage: 'L\'adresse ne doit pas dépasser {{ limit }} caractères'
    )]
    private ?string $address = null;

    #[ORM\Column(nullable: true)]
    #[Assert\NotBlank(message: 'Le code postal ne peut pas être vide')]
    #[Assert\Regex(
        pattern: '/^[0-9]{5}$/',
        message: 'Le code postal doit contenir 5 chiffres'
    )]
    private ?int $zipcode = null;


    #[ORM\Column(length: 50, nullable: true)]
    #[Assert\NotBlank(message: 'La ville ne peut pas être vide')]
    #[Assert\Length(
        min: 2,
        max: 50,
        minMessage: 'Le nom de la ville doit avoir au moins {{ limit }} caractères',
        maxMessage: 'Le nom de la ville ne doit pas dépasser {{ limit }} caractères'
    )]
    private ?string $city = null;




    //Attributs non utilisé dans le formulaire d'inscription   

    #[ORM\Column(type: 'json')]
    private array $roles = [];


    #[ORM\Column(type: 'boolean')]
    private ?bool $is_verified = false;


    #[ORM\Column(type: 'string', length: 100, nullable: true)]
    private $resetToken;

    #[ORM\ManyToMany(targetEntity: Patient::class, mappedBy: 'users')]
    private Collection $patients;

    #[ORM\Column(type: 'datetime_immutable', options: ['default' => 'CURRENT_TIMESTAMP'])]
    private ?\DateTimeImmutable $create_at = null;

    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $active;

    #[ORM\Column(length: 50)]
    private ?string $inscription_status = null;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Evaluation::class)]
    private Collection $evaluations;

    #[ORM\Column(length: 100)]
    private ?string $status = null;

    public function __construct()
    {
        $this->patients = new ArrayCollection();
        $this->create_at = new \DateTimeImmutable();
        //Lorsqu'un utilisateur est créer il a comme status "invalide" par defaut
        $this->inscription_status = "invalide";
        //Lorsqu'un utilisateur est créer il a comme Role "ROLE_USER" par defaut
        $this->roles = ['ROLE_USER'];
        $this->active = 1; // ou une autre valeur par défaut selon vos besoins
        $this->evaluations = new ArrayCollection();
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

    public function getLastName(): ?string
    {
        return $this->last_name;
    }

    public function setLastName(string $last_name): static
    {
        $this->last_name = $last_name;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

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

    public function getIsVerified(): ?bool
    {
        return $this->is_verified;
    }

    public function setIsVerified(bool $is_verified): self
    {
        $this->is_verified = $is_verified;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getResetToken()
    {
        return $this->resetToken;
    }

    /**
     * @param mixed $resetToken 
     * @return self
     */
    public function setResetToken(?string $resetToken): self
    {
        $this->resetToken = $resetToken;
        return $this;
    }




    public function getCreateAt(): ?\DateTimeImmutable
    {
        return $this->create_at;
    }

    public function setCreateAt(\DateTimeImmutable $create_at): static
    {
        $this->create_at = $create_at;

        return $this;
    }


    /**
     * @return Collection<int, Patient>
     */
    public function getPatients(): Collection
    {
        return $this->patients;
    }

    public function addPatient(Patient $patient): static
    {
        if (!$this->patients->contains($patient)) {
            $this->patients->add($patient);
            $patient->addUser($this);
        }

        return $this;
    }

    public function removePatient(Patient $patient): static
    {
        if ($this->patients->removeElement($patient)) {
            $patient->removeUser($this);
        }

        return $this;
    }

    public function getNoAdeli(): ?int
    {
        return $this->no_adeli;
    }

    public function setNoAdeli(int $no_adeli): static
    {
        $this->no_adeli = $no_adeli;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(?string $address): static
    {
        $this->address = $address;

        return $this;
    }

    public function getZipcode(): ?int
    {
        return $this->zipcode;
    }

    public function setZipcode(?int $zipcode): static
    {
        $this->zipcode = $zipcode;

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

    public function getActive(): ?int
    {
        return $this->active;
    }

    public function setActive(int $active): static
    {
        $this->active = $active;

        return $this;
    }

    public function getInscriptionStatus(): ?string
    {
        return $this->inscription_status;
    }

    public function setInscriptionStatus(string $inscription_status): static
    {
        $this->inscription_status = $inscription_status;

        return $this;
    }

    /**
     * @return Collection<int, Evaluation>
     */
    public function getEvaluations(): Collection
    {
        return $this->evaluations;
    }

    public function addEvaluation(Evaluation $evaluation): static
    {
        if (!$this->evaluations->contains($evaluation)) {
            $this->evaluations->add($evaluation);
            $evaluation->setUser($this);
        }

        return $this;
    }

    public function removeEvaluation(Evaluation $evaluation): static
    {
        if ($this->evaluations->removeElement($evaluation)) {
            // set the owning side to null (unless already changed)
            if ($evaluation->getUser() === $this) {
                $evaluation->setUser(null);
            }
        }

        return $this;
    }
}
