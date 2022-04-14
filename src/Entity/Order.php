<?php

namespace App\Entity;

use App\Repository\OrderRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=OrderRepository::class)
 * @ORM\Table(name="`order`")
 */
class Order
{
    
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $Periode;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $Mode;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="orders")
     */
    private $date_inscription_user_id;

    /**
     * @ORM\ManyToOne(targetEntity=Tableformation::class, inversedBy="orders")
     */
    private $id_formation;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $Etat;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPeriode(): ?string
    {
        return $this->Periode;
    }

    public function setPeriode(?string $Periode): self
    {
        $this->Periode = $Periode;

        return $this;
    }

    public function getMode(): ?string
    {
        return $this->Mode;
    }

    public function setMode(?string $Mode): self
    {
        $this->Mode = $Mode;
        return $this;
    }

    public function getDateInscriptionUserId(): ?User
    {
        return $this->date_inscription_user_id;
    }

    public function setDateInscriptionUserId(?User $date_inscription_user_id): self
    {
        $this->date_inscription_user_id = $date_inscription_user_id;

        return $this;
    }

    public function getIdFormation(): ?Tableformation
    {
        return $this->id_formation;
    }

    public function setIdFormation(?Tableformation $id_formation): self
    {
        $this->id_formation = $id_formation;

        return $this;
    }

    public function getEtat(): ?bool
    {
        return $this->Etat;
    }

    public function setEtat(bool $Etat): self
    {
        $this->Etat = $Etat;

        return $this;
    }


   

  
}
