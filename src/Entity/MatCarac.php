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
    private $usageCount;

    /**
     * @ORM\Column(type="string", length=64)
     */
    private $assetNum;

    /**
     * @ORM\Column(type="string", length=32)
     */
    private $assetType;

    /**
     * @ORM\Column(type="string", length=32)
     */
    private $caracteristique;

    /**
     * @ORM\Column(type="string", length=128)
     */
    private $status;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $commentaire;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\MatCal", mappedBy="matCarac")
     */
    private $matCals;

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
        return $this->usageCount;
    }

    public function setUsageCount(int $usageCount): self
    {
        $this->usageCount = $usageCount;

        return $this;
    }

    public function getAssetNum(): ?string
    {
        return $this->assetNum;
    }

    public function setAssetNum(string $assetNum): self
    {
        $this->assetNum = $assetNum;

        return $this;
    }

    public function getAssetType(): ?string
    {
        return $this->assetType;
    }

    public function setAssetType(string $assetType): self
    {
        $this->assetType = $assetType;

        return $this;
    }

    public function getCaracteristique(): ?string
    {
        return $this->caracteristique;
    }

    public function setCaracteristique(string $caracteristique): self
    {
        $this->caracteristique = $caracteristique;

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

    public function getCommentaire(): ?string
    {
        return $this->commentaire;
    }

    public function setCommentaire(?string $commentaire): self
    {
        $this->commentaire = $commentaire;

        return $this;
    }

    /**
     * @return Collection|MatCal[]
     */
    public function getMatCals(): Collection
    {
        return $this->matCals;
    }

    public function addMatCal(MatCal $matCal): self
    {
        if (!$this->matCals->contains($matCal)) {
            $this->matCals[] = $matCal;
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
