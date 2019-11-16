<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MatCaracRepository")
 */
class MatCarac
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $UsageCount;

    /**
     * @ORM\Column(type="string", length=64)
     */
    private $AssetNum;

    /**
     * @ORM\Column(type="string", length=32)
     */
    private $AssetType;

    /**
     * @ORM\Column(type="string", length=32)
     */
    private $Caracteristique;

    /**
     * @ORM\Column(type="string", length=128)
     */
    private $Status;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $Commentaire;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\MatCal", mappedBy="MatCarac")
     */
    private $MatCals;

    public function __construct()
    {
        $this->matCals = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsageCount(): ?int
    {
        return $this->UsageCount;
    }

    public function setUsageCount(int $UsageCount): self
    {
        $this->UsageCount = $UsageCount;

        return $this;
    }

    public function getAssetNum(): ?string
    {
        return $this->AssetNum;
    }

    public function setAssetNum(string $AssetNum): self
    {
        $this->AssetNum = $AssetNum;

        return $this;
    }

    public function getAssetType(): ?string
    {
        return $this->AssetType;
    }

    public function setAssetType(string $AssetType): self
    {
        $this->AssetType = $AssetType;

        return $this;
    }

    public function getCaracteristique(): ?string
    {
        return $this->Caracteristique;
    }

    public function setCaracteristique(string $Caracteristique): self
    {
        $this->Caracteristique = $Caracteristique;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->Status;
    }

    public function setStatus(string $Status): self
    {
        $this->Status = $Status;

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

    /**
     * @return Collection|MatCal[]
     */
    public function getMatCals(): Collection
    {
        return $this->MatCals;
    }

    public function addMatCal(MatCal $matCal): self
    {
        if (!$this->MatCals->contains($matCal)) {
            $this->MatCals[] = $matCal;
            $matCal->setAssetRef($this);
        }

        return $this;
    }

    public function removeMatCal(MatCal $matCal): self
    {
        if ($this->matCals->contains($matCal)) {
            $this->matCals->removeElement($matCal);
            // set the owning side to null (unless already changed)
            if ($matCal->getAssetRef() === $this) {
                $matCal->setAssetRef(null);
            }
        }

        return $this;
    }
}
