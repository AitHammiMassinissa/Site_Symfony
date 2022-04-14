<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Entity\Traits\Timestamp;
use App\Repository\CommandePayementRepository;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Traits\StripeTrait;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=CommandePayementRepository::class)
 */
class CommandePayement
{
    const DEVISE='eur';
    use Timestamp;
    use StripeTrait;
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="float")
     */
    private $Prix;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="commandePayements")
     */
    private $UserId;

    /**
     * @ORM\ManyToOne(targetEntity=Tableformation::class, inversedBy="commandePayements")
     */
    private $FormationId;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Reference;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPrix(): ?float
    {
        return $this->Prix;
    }

    public function setPrix(float $Prix): self
    {
        $this->Prix = $Prix;

        return $this;
    }

    public function getUserId(): ?User
    {
        return $this->UserId;
    }

    public function setUserId(?User $UserId): self
    {
        $this->UserId = $UserId;

        return $this;
    }

    public function getFormationId(): ?Tableformation
    {
        return $this->FormationId;
    }

    public function setFormationId(?Tableformation $FormationId): self
    {
        $this->FormationId = $FormationId;

        return $this;
    }

    public function getReference(): ?string
    {
        return $this->Reference;
    }

    public function setReference(string $Reference): self
    {
        $this->Reference = $Reference;

        return $this;
    }
}
