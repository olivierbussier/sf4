<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\BlogRepository")
 */
class Blog
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
    private $Date;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $Title;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $Texte;

    /**
     * @ORM\Column(type="integer")
     */
    private $Ordre;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $Link;

    /**
     * Une entrée blog a au plus 1 image
     * @ORM\OneToOne(targetEntity="App\Entity\BlogImages", cascade={"persist", "remove"})
     * @ORM\JoinColumn(name="ref_image_id", referencedColumnName="id")
     */
    private $RefImage;

    /**
     * @ORM\Column(type="string")
     */
    private $PositionImage;

    public function getId()
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->Date;
    }

    public function setDate(\DateTimeInterface $Date): self
    {
        $this->Date = $Date;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->Title;
    }

    public function setTitle(?string $Title): self
    {
        $this->Title = $Title;

        return $this;
    }

    public function getTexte(): ?string
    {
        return $this->Texte;
    }

    public function setTexte(?string $Texte): self
    {
        $this->Texte = $Texte;

        return $this;
    }

    public function getOrdre(): ?int
    {
        return $this->Ordre;
    }

    public function setOrdre(int $Ordre): self
    {
        $this->Ordre = $Ordre;

        return $this;
    }

    public function getLink(): ?string
    {
        return $this->Link;
    }

    public function setLink(?string $Link): self
    {
        $this->Link = $Link;

        return $this;
    }

    public function getRefImage(): ?BlogImages
    {
        return $this->RefImage;
    }

    public function setRefImage(?BlogImages $RefImage): self
    {
        $this->RefImage = $RefImage;

        return $this;
    }

    public function getPositionImage(): ?string
    {
        return $this->PositionImage;
    }

    public function setPositionImage(string $PositionImage): self
    {
        $this->PositionImage = $PositionImage;

        return $this;
    }
}
