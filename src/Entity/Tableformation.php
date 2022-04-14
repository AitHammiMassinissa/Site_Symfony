<?php

namespace App\Entity;

use App\Entity\Traits\Timestamp;
use App\Repository\TableformationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Monolog\DateTimeImmutable;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraint as Assert;

/**
 * @ORM\Entity(repositoryClass=TableformationRepository::class)
 * @Vich\Uploadable
 * @ORM\HasLifecycleCallbacks
 */
class Tableformation
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Nom_Formation;

    /**
     * @ORM\Column(type="text")
     */
    private $Description_formation;
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $imageName;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $Objectif;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $Prerequis;

    
    /**
     * @ORM\Column(type="integer")
     */
    private $NombreJour;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Disponibilite;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Lieu;

    /**
     * @ORM\Column(type="integer")
     */
    private $Prix;


    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $DateDebTroisMois;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $DateDebSixMois;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $DateDebUnAns;



    use Timestamp;
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomFormation(): ?string
    {
        return $this->Nom_Formation;
    }

    public function setNomFormation(?string $Nom_Formation): self
    {
        $this->Nom_Formation = $Nom_Formation;

        return $this;
    }

    public function getDescriptionFormation(): ?string
    {
        return $this->Description_formation;
    }

    public function setDescriptionFormation(?string $Description_formation): self
    {
        $this->Description_formation = $Description_formation;

        return $this;
    }

    public function getImageName(): ?string
    {
        return $this->imageName;
    }

    public function setImageName(?string $imageName): self
    {
        $this->imageName = $imageName;

        return $this;
    }

    public function getObjectif(): ?string
    {
        return $this->Objectif;
    }

    public function setObjectif(?string $Objectif): self
    {
        $this->Objectif = $Objectif;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getPrerequis()
    {
        return $this->Prerequis;
    }

    /**
     * @param mixed $Prerequis
     */
    public function setPrerequis($Prerequis): void
    {
        $this->Prerequis = $Prerequis;
    }






    public function getNombreJour(): ?int
    {
        return $this->NombreJour;
    }

    public function setNombreJour(int $NombreJour): self
    {
        $this->NombreJour = $NombreJour;

        return $this;
    }

    public function getDisponibilite(): ?string
    {
        return $this->Disponibilite;
    }

    public function setDisponibilite(string $Disponibilite): self
    {
        $this->Disponibilite = $Disponibilite;

        return $this;
    }

    public function getLieu(): ?string
    {
        return $this->Lieu;
    }

    public function setLieu(string $Lieu): self
    {
        $this->Lieu = $Lieu;

        return $this;
    }

    public function getPrix(): ?int
    {
        return $this->Prix;
    }

    public function setPrix(int $Prix): self
    {
        $this->Prix = $Prix;

        return $this;
    }

    public function setDate3(?\DateTimeInterface $date3): self
    {
        $this->date3 = $date3;

        return $this;
    }

    public function getDateDebTroisMois(): ?\DateTimeInterface
    {
        return $this->DateDebTroisMois;
    }

    public function setDateDebTroisMois(?\DateTimeInterface $DateDebTroisMois): self
    {
        $this->DateDebTroisMois = $DateDebTroisMois;

        return $this;
    }

    public function getDateDebSixMois(): ?\DateTimeInterface
    {
        return $this->DateDebSixMois;
    }

    public function setDateDebSixMois(?\DateTimeInterface $DateDebSixMois): self
    {
        $this->DateDebSixMois = $DateDebSixMois;

        return $this;
    }

    public function getDateDebUnAns(): ?\DateTimeInterface
    {
        return $this->DateDebUnAns;
    }

    public function setDateDebUnAns(?\DateTimeInterface $DateDebUnAns): self
    {
        $this->DateDebUnAns = $DateDebUnAns;

        return $this;
    }
        /**
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     *
     * @Vich\UploadableField(mapping="formation_image", fileNameProperty="imageName")
     *
     * @var File|null
     */
    private $imageFile;

    /**
     * @ORM\ManyToMany(targetEntity=User::class, mappedBy="formationIscrite")
     */
    private $users;

    /**
     * @ORM\OneToMany(targetEntity=Order::class, mappedBy="id_formation")
     */
    private $orders;

    /**
     * @ORM\OneToMany(targetEntity=CommandePayement::class, mappedBy="FormationId")
     */
    private $commandePayements;

    public function __construct()
    {
        $this->users = new ArrayCollection();
        $this->orders = new ArrayCollection();
        $this->commandePayements = new ArrayCollection();
    }
    /**
     * If manually uploading a file (i.e. not using Symfony Form) ensure an instance
     * of 'UploadedFile' is injected into this setter to trigger the update. If this
     * bundle's configuration parameter 'inject_on_load' is set to 'true' this setter
     * must be able to accept an instance of 'File' as the bundle will inject one here
     * during Doctrine hydration.
     *
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile|null $imageFile
     */
    public function setImageFile(?File $imageFile = null): void
    {
        $this->imageFile = $imageFile;

        if (null !== $imageFile) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->setUpdatedAt(new \DateTimeImmutable);
        }
    }
    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    /**
     * @return Collection|User[]
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
            $user->addFormationIscrite($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->removeElement($user)) {
            $user->removeFormationIscrite($this);
        }

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
            $order->setIdFormation($this);
        }

        return $this;
    }

    public function removeOrder(Order $order): self
    {
        if ($this->orders->removeElement($order)) {
            // set the owning side to null (unless already changed)
            if ($order->getIdFormation() === $this) {
                $order->setIdFormation(null);
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
            $commandePayement->setFormationId($this);
        }

        return $this;
    }

    public function removeCommandePayement(CommandePayement $commandePayement): self
    {
        if ($this->commandePayements->removeElement($commandePayement)) {
            // set the owning side to null (unless already changed)
            if ($commandePayement->getFormationId() === $this) {
                $commandePayement->setFormationId(null);
            }
        }

        return $this;
    }
}
