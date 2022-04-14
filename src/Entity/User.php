<?php

namespace App\Entity;

use App\Entity\Traits\Timestamp;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Monolog\DateTimeImmutable;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @ORM\HasLifecycleCallbacks
 * @ORM\Table(name="users")
 * @UniqueEntity(fields={"email"}, message="There is already an account with this email")
 */
class User implements UserInterface
{
    use Timestamp;
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;
  
    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $firstName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $lastName;

   

    /**
     * @ORM\Column(type="boolean")
     */
    private $isVerified = false;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Civilite;


    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $Societe;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $NumeroDeRue;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $NomDeRue;


    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $CodePostale;



    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $Numero;

    /**
     * @ORM\ManyToOne(targetEntity=Pays::class)
     * @ORM\JoinColumn(nullable=true)
     */
    private $pays;

    /**
     * @ORM\Column(type="string",length=255,nullable=true)
     */
    private $Ville;

    /**
     * @ORM\ManyToMany(targetEntity=Tableformation::class, inversedBy="users")
     */
    private $formationIscrite;

    /**
     * @ORM\OneToMany(targetEntity=Order::class, mappedBy="date_inscription")
     */
    private $orders;

    /**
     * @ORM\OneToMany(targetEntity=CommandePayement::class, mappedBy="UserId")
     */
    private $commandePayements;

    public function __construct()
    {
        $this->formationIscrite = new ArrayCollection();
        $this->orders = new ArrayCollection();
        $this->commandePayements = new ArrayCollection();
    }

   



    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
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

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

   
public function getFullName():string{
    return $this->getFirstName() .' '.$this->getLastName();
}
    /**
     * Get either a Gravatar URL or complete image tag for a specified email address.
     *
     * @param string $email The email address
     * @param string $s Size in pixels, defaults to 80px [ 1 - 2048 ]
     * @param string $d Default imageset to use [ 404 | mp | identicon | monsterid | wavatar ]
     * @param string $r Maximum rating (inclusive) [ g | pg | r | x ]
     * @param boole $img True to return a complete IMG tag False for just the URL
     * @param array $atts Optional, additional key/value attributes to include in the IMG tag
     * @return String containing either just a URL or a complete image tag
     * @source https://gravatar.com/site/implement/images/php/
     */

public function get_gravatar(?int $size=100) {
        return  sprintf('https://www.gravatar.com/avatar/%s?s=%d',md5(strtolower(trim( $this->getEmail()) ) ),$size);
    }
public function isVerified(): bool
{
    return $this->isVerified;
}

public function setIsVerified(bool $isVerified): self
{
    $this->isVerified = $isVerified;

    return $this;
}

public function getCivilite(): ?string
{
    return $this->Civilite;
}

public function setCivilite(string $Civilite): self
{
    $this->Civilite = $Civilite;

    return $this;
}


public function getSociete(): ?string
{
    return $this->Societe;
}

public function setSociete(?string $Societe): self
{
    $this->Societe = $Societe;

    return $this;
}

public function getNumeroDeRue(): ?int
{
    return $this->NumeroDeRue;
}

public function setNumeroDeRue(?int $NumeroDeRue): self
{
    $this->NumeroDeRue = $NumeroDeRue;

    return $this;
}

public function getNomDeRue(): ?string
{
    return $this->NomDeRue;
}

public function setNomDeRue(?string $NomDeRue): self
{
    $this->NomDeRue = $NomDeRue;

    return $this;
}


public function getCodePostale(): ?int
{
    return $this->CodePostale;
}

public function setCodePostale(?int $CodePostale): self
{
    $this->CodePostale = $CodePostale;

    return $this;
}

public function getNumero(): ?string
{
    return $this->Numero;
}

public function setNumero(?string $Numero): self
{
    $this->Numero = $Numero;

    return $this;
}

public function getIsVerified(): ?bool
{
    return $this->isVerified;
}


public function getVille(): ?string
{
    return $this->Ville;
}

public function setVille(string $Ville): self
{
    $this->Ville = $Ville;

    return $this;
}

public function getPays(): ?Pays
{
    return $this->pays;
}

public function setPays(?Pays $pays): self
{
    $this->pays = $pays;

    return $this;
}

/**
 * @return Collection|Tableformation[]
 */
public function getFormationIscrite(): Collection
{
    return $this->formationIscrite;
}

public function addFormationIscrite(Tableformation $formationIscrite): self
{
    if (!$this->formationIscrite->contains($formationIscrite)) {
        $this->formationIscrite[] = $formationIscrite;
    }

    return $this;
}

public function removeFormationIscrite(Tableformation $formationIscrite): self
{
    $this->formationIscrite->removeElement($formationIscrite);

    return $this;
}

/**
 * @return Collection|Order[]
 */
public function getOrders(): Collection
{
    return $this->orders;
}

public function addOrder(Order $order): self
{
    if (!$this->orders->contains($order)) {
        $this->orders[] = $order;
        $order->setDateInscriptionUserId($this);
    }

    return $this;
}

public function removeOrder(Order $order): self
{
    if ($this->orders->removeElement($order)) {
        // set the owning side to null (unless already changed)
        if ($order->getDateInscriptionUserId() === $this) {
            $order->setDateInscriptionUserId(null);
        }
    }

    return $this;
}

/**
 * @return Collection|CommandePayement[]
 */
public function getCommandePayements(): Collection
{
    return $this->commandePayements;
}

public function addCommandePayement(CommandePayement $commandePayement): self
{
    if (!$this->commandePayements->contains($commandePayement)) {
        $this->commandePayements[] = $commandePayement;
        $commandePayement->setUserId($this);
    }

    return $this;
}

public function removeCommandePayement(CommandePayement $commandePayement): self
{
    if ($this->commandePayements->removeElement($commandePayement)) {
        // set the owning side to null (unless already changed)
        if ($commandePayement->getUserId() === $this) {
            $commandePayement->setUserId(null);
        }
    }

    return $this;
}
}
