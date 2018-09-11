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
        return $this->User;
    }

    public function setUser(?Adherent $User): self
    {
        $this->User = $User;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->Type;
    }

    public function setType(string $Type): self
    {
        $this->Type = $Type;

        return $this;
    }

    public function getDateObtention(): ?DateTimeInterface
    {
        return $this->DateObtention;
    }

    public function setDateObtention(DateTimeInterface $DateObtention): self
    {
        $this->DateObtention = $DateObtention;

        return $this;
    }

    public function getDateRecyclage(): ?DateTimeInterface
    {
        return $this->DateRecyclage;
    }

    public function setDateRecyclage(DateTimeInterface $DateRecyclage): self
    {
        $this->DateRecyclage = $DateRecyclage;

        return $this;
    }

    public function getNumero(): ?string
    {
        return $this->Numero;
    }

    public function setNumero(string $Numero): self
    {
        $this->Numero = $Numero;

        return $this;
    }

    public function getCommentaire(): ?string
    {
        return $this->Commentaire;
    }

    public function setCommentaire(string $Commentaire): self
    {
        $this->Commentaire = $Commentaire;

        return $this;
    }

}
