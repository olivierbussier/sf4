<?php

namespace App\Entity;

use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AdherentRepository")
 * @UniqueEntity(
 *     fields = {"Username"},
 *     message = "Le nom d'adhérent est déjà utilisé"
 * )
 */
class Adherent implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Username;

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
     * @Assert\Email()
     */
    private $Mail;

    /**
     * @ORM\Column(type="json", nullable=true)
     */
    private $Roles = [];

    /**
     * @ORM\Column(type="json", nullable=true)
     */
    private $ListeDroits = [];

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $CodeSecret;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(min="8", minMessage="Votre mot de passe doit faire minimum 8 caractères")
     */
    private $Password;

    /**
     * @Assert\EqualTo(propertyPath="Password", message="Password et confirm_password sont différents")
     */
    public $confirm_Password;

    /**
     * @ORM\Column(type="string", length=32)
     */
    private $Genre;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $Adresse1;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $Adresse2;

    /**
     * @ORM\Column(type="string", length=32, nullable=true)
     */
    private $CodePostal;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $Ville;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $Profession;

    /**
     * @ORM\Column(type="datetime")
     */
    private $DateNaissance;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $LieuNaissance;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $DepartementNaissance;

    /**
     * @ORM\Column(type="string", length=64, nullable=true)
     */
    private $TelFix;

    /**
     * @ORM\Column(type="string", length=64, nullable=true)
     */
    private $TelPort;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $fEtudiant;

    /**
     * @ORM\Column(type="string", length=64)
     */
    private $NiveauSca;

    /**
     * @ORM\Column(type="string", length=64)
     */
    private $NiveauApn;

    /**
     * @ORM\Column(type="json", nullable=true)
     */
    private $Diplomes = [];

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $fApneeSca;

    /**
     * @ORM\Column(type="string", length=64, nullable=true)
     */
    private $Activite;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $fBenevole;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $fEncadrant;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $AccidentNom;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $AccidentPrenom;

    /**
     * @ORM\Column(type="string", length=64, nullable=true)
     */
    private $AccidentTelFix;

    /**
     * @ORM\Column(type="string", length=64, nullable=true)
     */
    private $AccidentTelPort;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $DateCertif;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $fAllergAspirine;

    /**
     * @ORM\Column(type="string", length=32, nullable=true)
     */
    private $Licence;

    /**
     * @ORM\Column(type="string", length=32, nullable=true)
     */
    private $Cotisation;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $fCarteGUC;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $fCarteSIUAPS;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $fMailGUC;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $fTrombi;

    /**
     * @ORM\Column(type="string", length=32, nullable=true)
     */
    private $EnvoiGUC;

    /**
     * @ORM\Column(type="string", length=32, nullable=true)
     */
    private $EnvoiSIUAPS;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $Facture;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $RefFacture;

    /**
     * @ORM\Column(type="string", length=32, nullable=true)
     */
    private $Assurance;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $PretMateriel;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $PretMaterielOld;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $MineurNom;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $MineurPrenom;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $MineurQualite;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $ModifUser;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $DateModifUser;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $DatePremInscr;

    /**
     * @ORM\Column(type="json", length=512, nullable=true)
     */
    private $AdminOK = [];

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $Comments;

    /**
     * @ORM\Column(type="string", length=32, nullable=true)
     */
    private $ReducFamilleID;

    /**
     * @ORM\Column(type="string", length=32, nullable=true)
     */
    private $ReducFam;

    public function getId()
    {
        return $this->id;
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

    public function getMail(): ?string
    {
        return $this->Mail;
    }

    public function setMail(string $Mail): self
    {
        $this->Mail = $Mail;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->Password;
    }

    public function setPassword(string $Password): self
    {
        $this->Password = $Password;

        return $this;
    }

    public function eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method.
    }

    public function getSalt()
    {
        // TODO: Implement getSalt() method.
    }

    /**
     * @return array (Role|string)[] The user roles
     */
    public function getRoles()
    {
        return $this->Roles;
    }

    /**
     * @param mixed $Roles
     */
    public function setRoles($Roles): void
    {
        $this->Roles = $Roles;
    }

    /**
     * @return mixed
     */
    public function getListeDroits()
    {
        return $this->ListeDroits;
    }

    /**
     * @param mixed $ListeDroits
     */
    public function setListeDroits($ListeDroits): void
    {
        $this->ListeDroits = $ListeDroits;
    }

    /**
     * @param mixed $Username
     */
    public function setUsername($Username): void
    {
        $this->Username = $Username;
    }

    public function getUsername()
    {
        return $this->Username;
    }

    public function getGenre(): ?string
    {
        return $this->Genre;
    }

    public function setGenre(?string $Genre): self
    {
        $this->Genre = $Genre;

        return $this;
    }

    public function getAdresse1(): ?string
    {
        return $this->Adresse1;
    }

    public function setAdresse1(?string $Adresse1): self
    {
        $this->Adresse1 = $Adresse1;

        return $this;
    }

    public function getAdresse2(): ?string
    {
        return $this->Adresse2;
    }

    public function setAdresse2(?string $Adresse2): self
    {
        $this->Adresse2 = $Adresse2;

        return $this;
    }

    public function getCodePostal(): ?string
    {
        return $this->CodePostal;
    }

    public function setCodePostal(?string $CodePostal): self
    {
        $this->CodePostal = $CodePostal;

        return $this;
    }

    public function getVille(): ?string
    {
        return $this->Ville;
    }

    public function setVille(?string $Ville): self
    {
        $this->Ville = $Ville;

        return $this;
    }

    public function getProfession(): ?string
    {
        return $this->Profession;
    }

    public function setProfession(?string $Profession): self
    {
        $this->Profession = $Profession;

        return $this;
    }

    public function getDateNaissance(): ?DateTimeInterface
    {
        return $this->DateNaissance;
    }

    public function setDateNaissance(DateTimeInterface $DateNaissance): self
    {
        $this->DateNaissance = $DateNaissance;

        return $this;
    }

    public function getLieuNaissance(): ?string
    {
        return $this->LieuNaissance;
    }

    public function setLieuNaissance(?string $LieuNaissance): self
    {
        $this->LieuNaissance = $LieuNaissance;

        return $this;
    }

    public function getDepartementNaissance(): ?string
    {
        return $this->DepartementNaissance;
    }

    public function setDepartementNaissance(?string $DepartementNaissance): self
    {
        $this->DepartementNaissance = $DepartementNaissance;

        return $this;
    }

    public function getTelFix(): ?string
    {
        return $this->TelFix;
    }

    public function setTelFix(?string $TelFix): self
    {
        $this->TelFix = $TelFix;

        return $this;
    }

    public function getTelPort(): ?string
    {
        return $this->TelPort;
    }

    public function setTelPort(?string $TelPort): self
    {
        $this->TelPort = $TelPort;

        return $this;
    }

    public function getFEtudiant(): ?bool
    {
        return $this->fEtudiant;
    }

    public function setFEtudiant(?bool $fEtudiant): self
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

    public function getFApneeSca(): ?bool
    {
        return $this->fApneeSca;
    }

    public function setFApneeSca(?bool $fApneeSca): self
    {
        $this->fApneeSca = $fApneeSca;

        return $this;
    }

    public function getActivite(): ?string
    {
        return $this->Activite;
    }

    public function setActivite(?string $Activite): self
    {
        $this->Activite = $Activite;

        return $this;
    }

    public function getFBenevole(): ?bool
    {
        return $this->fBenevole;
    }

    public function setFBenevole(?bool $fBenevole): self
    {
        $this->fBenevole = $fBenevole;

        return $this;
    }

    public function getFEncadrant(): ?bool
    {
        return $this->fEncadrant;
    }

    public function setFEncadrant(?bool $fEncadrant): self
    {
        $this->fEncadrant = $fEncadrant;

        return $this;
    }

    public function getAccidentNom(): ?string
    {
        return $this->AccidentNom;
    }

    public function setAccidentNom(?string $AccidentNom): self
    {
        $this->AccidentNom = $AccidentNom;

        return $this;
    }

    public function getAccidentPrenom(): ?string
    {
        return $this->AccidentPrenom;
    }

    public function setAccidentPrenom(?string $AccidentPrenom): self
    {
        $this->AccidentPrenom = $AccidentPrenom;

        return $this;
    }

    public function getAccidentTelFix(): ?string
    {
        return $this->AccidentTelFix;
    }

    public function setAccidentTelFix(?string $AccidentTelFix): self
    {
        $this->AccidentTelFix = $AccidentTelFix;

        return $this;
    }

    public function getAccidentTelPort(): ?string
    {
        return $this->AccidentTelPort;
    }

    public function setAccidentTelPort(?string $AccidentTelPort): self
    {
        $this->AccidentTelPort = $AccidentTelPort;

        return $this;
    }

    public function getDateCertif(): ?DateTimeInterface
    {
        return $this->DateCertif;
    }

    public function setDateCertif(?DateTimeInterface $DateCertif): self
    {
        $this->DateCertif = $DateCertif;

        return $this;
    }

    public function getFAllergAspirine(): ?bool
    {
        return $this->fAllergAspirine;
    }

    public function setFAllergAspirine(?bool $fAllergAspirine): self
    {
        $this->fAllergAspirine = $fAllergAspirine;

        return $this;
    }

    public function getLicence(): ?string
    {
        return $this->Licence;
    }

    public function setLicence(?string $Licence): self
    {
        $this->Licence = $Licence;

        return $this;
    }

    public function getCotisation(): ?string
    {
        return $this->Cotisation;
    }

    public function setCotisation(?string $Cotisation): self
    {
        $this->Cotisation = $Cotisation;

        return $this;
    }

    public function getFCarteGUC(): ?bool
    {
        return $this->fCarteGUC;
    }

    public function setFCarteGUC(?bool $fCarteGUC): self
    {
        $this->fCarteGUC = $fCarteGUC;

        return $this;
    }

    public function getFCarteSIUAPS(): ?bool
    {
        return $this->fCarteSIUAPS;
    }

    public function setFCarteSIUAPS(?bool $fCarteSIUAPS): self
    {
        $this->fCarteSIUAPS = $fCarteSIUAPS;

        return $this;
    }

    public function getFMailGUC(): ?bool
    {
        return $this->fMailGUC;
    }

    public function setFMailGUC(?bool $fMailGUC): self
    {
        $this->fMailGUC = $fMailGUC;

        return $this;
    }

    public function getFTrombi(): ?bool
    {
        return $this->fTrombi;
    }

    public function setFTrombi(?bool $fTrombi): self
    {
        $this->fTrombi = $fTrombi;

        return $this;
    }

    public function getEnvoiGUC(): ?string
    {
        return $this->EnvoiGUC;
    }

    public function setEnvoiGUC(?string $EnvoiGUC): self
    {
        $this->EnvoiGUC = $EnvoiGUC;

        return $this;
    }

    public function getEnvoiSIUAPS(): ?string
    {
        return $this->EnvoiSIUAPS;
    }

    public function setEnvoiSIUAPS(?string $EnvoiSIUAPS): self
    {
        $this->EnvoiSIUAPS = $EnvoiSIUAPS;

        return $this;
    }

    public function getFacture(): ?string
    {
        return $this->Facture;
    }

    public function setFacture(?string $Facture): self
    {
        $this->Facture = $Facture;

        return $this;
    }

    public function getRefFacture(): ?string
    {
        return $this->RefFacture;
    }

    public function setRefFacture(?string $RefFacture): self
    {
        $this->RefFacture = $RefFacture;

        return $this;
    }

    public function getAssurance(): ?string
    {
        return $this->Assurance;
    }

    public function setAssurance(?string $Assurance): self
    {
        $this->Assurance = $Assurance;

        return $this;
    }

    public function getPretMateriel(): ?bool
    {
        return $this->PretMateriel;
    }

    public function setPretMateriel(?bool $PretMateriel): self
    {
        $this->PretMateriel = $PretMateriel;

        return $this;
    }

    public function getPretMaterielOld(): ?bool
    {
        return $this->PretMaterielOld;
    }

    public function setPretMaterielOld(?bool $PretMaterielOld): self
    {
        $this->PretMaterielOld = $PretMaterielOld;

        return $this;
    }

    public function getMineurNom(): ?string
    {
        return $this->MineurNom;
    }

    public function setMineurNom(?string $MineurNom): self
    {
        $this->MineurNom = $MineurNom;

        return $this;
    }

    public function getMineurPrenom(): ?string
    {
        return $this->MineurPrenom;
    }

    public function setMineurPrenom(?string $MineurPrenom): self
    {
        $this->MineurPrenom = $MineurPrenom;

        return $this;
    }

    public function getMineurQualite(): ?string
    {
        return $this->MineurQualite;
    }

    public function setMineurQualite(?string $MineurQualite): self
    {
        $this->MineurQualite = $MineurQualite;

        return $this;
    }

    public function getModifUser(): ?string
    {
        return $this->ModifUser;
    }

    public function setModifUser(?string $ModifUser): self
    {
        $this->ModifUser = $ModifUser;

        return $this;
    }

    public function getDateModifUser(): ?DateTimeInterface
    {
        return $this->DateModifUser;
    }

    public function setDateModifUser(?DateTimeInterface $DateModifUser): self
    {
        $this->DateModifUser = $DateModifUser;

        return $this;
    }

    public function getDatePremInscr(): ?DateTimeInterface
    {
        return $this->DatePremInscr;
    }

    public function setDatePremInscr(?DateTimeInterface $DatePremInscr): self
    {
        $this->DatePremInscr = $DatePremInscr;

        return $this;
    }

    public function getAdminOK(): ?string
    {
        return $this->AdminOK;
    }

    public function setAdminOK(?string $AdminOK): self
    {
        $this->AdminOK = $AdminOK;

        return $this;
    }

    public function getComments(): ?string
    {
        return $this->Comments;
    }

    public function setComments(?string $Comments): self
    {
        $this->Comments = $Comments;

        return $this;
    }

    public function getReducFamilleID(): ?string
    {
        return $this->ReducFamilleID;
    }

    public function setReducFamilleID(?string $ReducFamilleID): self
    {
        $this->ReducFamilleID = $ReducFamilleID;

        return $this;
    }

    public function getReducFam(): ?string
    {
        return $this->ReducFam;
    }

    public function setReducFam(?string $ReducFam): self
    {
        $this->ReducFam = $ReducFam;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getCodeSecret()
    {
        return $this->CodeSecret;
    }

    /**
     * @param mixed $CodeSecret
     */
    public function setCodeSecret($CodeSecret): void
    {
        $this->CodeSecret = $CodeSecret;
    }

    /**
     * @return mixed
     */
    public function getDiplomes()
    {
        return $this->Diplomes;
    }

    /**
     * @param mixed $Diplomes
     */
    public function setDiplomes($Diplomes): void
    {
        $this->Diplomes = $Diplomes;
    }
}
