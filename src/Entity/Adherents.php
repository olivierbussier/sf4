<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AdherentsRepository")
 */
class Adherents
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=128)
     */
    private $Genre;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Nom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Prenom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Add1;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Add2;

    /**
     * @ORM\Column(type="string", length=32)
     */
    private $CodePostal;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Ville;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Profession;

    /**
     * @ORM\Column(type="datetime")
     */
    private $DateNaiss;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $LieuNaiss;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $DepartNaiss;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $TelFix;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $TelPort;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Mail;

    /**
     * @ORM\Column(type="boolean")
     */
    private $fEtudiant;

    /**
     * @ORM\Column(type="string", length=32)
     */
    private $NiveauSca;

    /**
     * @ORM\Column(type="string", length=32)
     */
    private $NiveauApn;

    /**
     * @ORM\Column(type="boolean")
     */
    private $ApneeSca;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Diplomes", mappedBy="User")
     */
    private $Diplomes;

    public function __construct()
    {
        $this->Diplomes = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getGenre(): ?string
    {
        return $this->Genre;
    }

    public function setGenre(string $Genre): self
    {
        $this->Genre = $Genre;

        return $this;
    }

    public function getNom(): ?string
    {
        return $this->Nom;
    }

    public function setNom(string $Nom): self
    {
        $this->Nom = $Nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->Prenom;
    }

    public function setPrenom(string $Prenom): self
    {
        $this->Prenom = $Prenom;

        return $this;
    }

    public function getAdd1(): ?string
    {
        return $this->Add1;
    }

    public function setAdd1(string $Add1): self
    {
        $this->Add1 = $Add1;

        return $this;
    }

    public function getAdd2(): ?string
    {
        return $this->Add2;
    }

    public function setAdd2(string $Add2): self
    {
        $this->Add2 = $Add2;

        return $this;
    }

    public function getCodePostal(): ?string
    {
        return $this->CodePostal;
    }

    public function setCodePostal(string $CodePostal): self
    {
        $this->CodePostal = $CodePostal;

        return $this;
    }

    public function getVille(): ?string
    {
        return $this->Ville;
    }

    public function setVille(string $Ville): self
    {
        $this->Ville = $Ville;

        return $this;
    }

    public function getProfession(): ?string
    {
        return $this->Profession;
    }

    public function setProfession(string $Profession): self
    {
        $this->Profession = $Profession;

        return $this;
    }

    public function getDateNaiss(): ?\DateTimeInterface
    {
        return $this->DateNaiss;
    }

    public function setDateNaiss(\DateTimeInterface $DateNaiss): self
    {
        $this->DateNaiss = $DateNaiss;

        return $this;
    }

    public function getLieuNaiss(): ?string
    {
        return $this->LieuNaiss;
    }

    public function setLieuNaiss(string $LieuNaiss): self
    {
        $this->LieuNaiss = $LieuNaiss;

        return $this;
    }

    public function getDepartNaiss(): ?string
    {
        return $this->DepartNaiss;
    }

    public function setDepartNaiss(string $DepartNaiss): self
    {
        $this->DepartNaiss = $DepartNaiss;

        return $this;
    }

    public function getTelFix(): ?string
    {
        return $this->TelFix;
    }

    public function setTelFix(string $TelFix): self
    {
        $this->TelFix = $TelFix;

        return $this;
    }

    public function getTelPort(): ?string
    {
        return $this->TelPort;
    }

    public function setTelPort(string $TelPort): self
    {
        $this->TelPort = $TelPort;

        return $this;
    }

    public function getMail(): ?string
    {
        return $this->Mail;
    }

    public function setMail(string $Mail): self
    {
        $this->Mail = $Mail;

        return $this;
    }

    public function getFEtudiant(): ?bool
    {
        return $this->fEtudiant;
    }

    public function setFEtudiant(bool $fEtudiant): self
    {
        $this->fEtudiant = $fEtudiant;

        return $this;
    }

    public function getNiveauSca(): ?string
    {
        return $this->NiveauSca;
    }

    public function setNiveauSca(string $NiveauSca): self
    {
        $this->NiveauSca = $NiveauSca;

        return $this;
    }

    public function getNiveauApn(): ?string
    {
        return $this->NiveauApn;
    }

    public function setNiveauApn(string $NiveauApn): self
    {
        $this->NiveauApn = $NiveauApn;

        return $this;
    }

    public function getApneeSca(): ?bool
    {
        return $this->ApneeSca;
    }

    public function setApneeSca(bool $ApneeSca): self
    {
        $this->ApneeSca = $ApneeSca;

        return $this;
    }

    /**
     * @return Collection|Diplomes[]
     */
    public function getDiplomes(): Collection
    {
        return $this->Diplomes;
    }

    public function addDiplome(Diplomes $diplome): self
    {
        if (!$this->Diplomes->contains($diplome)) {
            $this->Diplomes[] = $diplome;
            $diplome->setUser($this);
        }

        return $this;
    }

    public function removeDiplome(Diplomes $diplome): self
    {
        if ($this->Diplomes->contains($diplome)) {
            $this->Diplomes->removeElement($diplome);
            // set the owning side to null (unless already changed)
            if ($diplome->getUser() === $this) {
                $diplome->setUser(null);
            }
        }

        return $this;
    }
}
