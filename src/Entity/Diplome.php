<?php

namespace App\Entity;

use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DiplomeRepository")
 */
class Diplome
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Adherent", inversedBy="diplomes")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $type;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $dateObtention;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $dateRecyclage;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $numero;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $commentaire;

    public function getId()
    {
        return $this->id;
    }

    public function getUser(): ?Adherent
    {
        return $this->user;
    }

    public function setUser(?Adherent $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getDateObtention(): ?DateTimeInterface
    {
        return $this->dateObtention;
    }

    public function setDateObtention(DateTimeInterface $dateObtention): self
    {
        $this->dateObtention = $dateObtention;

        return $this;
    }

    public function getDateRecyclage(): ?DateTimeInterface
    {
        return $this->dateRecyclage;
    }

    public function setDateRecyclage(DateTimeInterface $dateRecyclage): self
    {
        $this->dateRecyclage = $dateRecyclage;

        return $this;
    }

    public function getNumero(): ?string
    {
        return $this->numero;
    }

    public function setNumero(string $numero): self
    {
        $this->numero = $numero;

        return $this;
    }

    public function getCommentaire(): ?string
    {
        return $this->commentaire;
    }

    public function setCommentaire(string $commentaire): self
    {
        $this->commentaire = $commentaire;

        return $this;
    }

}
