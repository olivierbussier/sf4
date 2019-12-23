<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MatCalRepository")
 */
class MatCal
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateDebut;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateFin;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $typeSortie;

    /**
     * @ORM\Column(type="string", length=64)
     */
    private $status;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $assetText;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $commentaire;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\MatCarac", inversedBy="matCals")
     * @ORM\JoinColumn(nullable=false)
     */
    private $matCarac;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="matCals")
     * @ORM\JoinColumn(nullable=true)
     */
    private $refUser;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $refResa;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getDateDebut(): ?\DateTimeInterface
    {
        return $this->dateDebut;
    }

    public function setDateDebut(\DateTimeInterface $dateDebut): self
    {
        $this->dateDebut = $dateDebut;

        return $this;
    }

    public function getDateFin(): ?\DateTimeInterface
    {
        return $this->dateFin;
    }

    public function setDateFin(\DateTimeInterface $dateFin): self
    {
        $this->dateFin = $dateFin;

        return $this;
    }

    public function getTypeSortie(): ?string
    {
        return $this->typeSortie;
    }

    public function setTypeSortie(string $typeSortie): self
    {
        $this->typeSortie = $typeSortie;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getAssetText(): ?string
    {
        return $this->assetText;
    }

    public function setAssetText(string $assetText): self
    {
        $this->assetText = $assetText;

        return $this;
    }

    public function getCommentaire(): ?string
    {
        return $this->commentaire;
    }

    public function setCommentaire(?string $commentaire): self
    {
        $this->commentaire = $commentaire;

        return $this;
    }

    public function getMatCarac(): ?MatCarac
    {
        return $this->matCarac;
    }

    public function setMatCarac(?MatCarac $matCarac): self
    {
        $this->matCarac = $matCarac;

        return $this;
    }

    public function getRefUser(): ?User
    {
        return $this->refUser;
    }

    public function setRefUser(?User $refUser): self
    {
        $this->refUser = $refUser;

        return $this;
    }

    public function getRefResa(): ?int
    {
        return $this->refResa;
    }

    public function setRefResa(int $refResa): self
    {
        $this->refResa = $refResa;

        return $this;
    }
}
