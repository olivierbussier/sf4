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
    private $Commentaire;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\MatCarac", inversedBy="MatCals")
     * @ORM\JoinColumn(nullable=false)
     */
    private $MatCarac;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Adherent", inversedBy="matCals")
     * @ORM\JoinColumn(nullable=true)
     */
    private $RefUser;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $RefResa;

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
        return $this->Commentaire;
    }

    public function setCommentaire(?string $Commentaire): self
    {
        $this->Commentaire = $Commentaire;

        return $this;
    }

    public function getMatCarac(): ?MatCarac
    {
        return $this->MatCarac;
    }

    public function setMatCarac(?MatCarac $matCarac): self
    {
        $this->MatCarac = $matCarac;

        return $this;
    }

    public function getRefUser(): ?Adherent
    {
        return $this->RefUser;
    }

    public function setRefUser(?Adherent $RefUser): self
    {
        $this->RefUser = $RefUser;

        return $this;
    }

    public function getRefResa(): ?int
    {
        return $this->RefResa;
    }

    public function setRefResa(int $RefResa): self
    {
        $this->RefResa = $RefResa;

        return $this;
    }
}
