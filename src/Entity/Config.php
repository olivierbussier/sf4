<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ConfigRepository")
 */
class Config
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
    private $p_annee;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $nb_sess_req;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $path_photo;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $path_certif;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $path_fiches;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $path_fact;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $path_team;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $LOG_AP;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $LOG_DB;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $LOG_ML;

    /**
     * @ORM\Column(type="integer")
     */
    private $status_inscriptions;

    public function getId()
    {
        return $this->id;
    }

    public function getPAnnee(): ?int
    {
        return $this->p_annee;
    }

    public function setPAnnee(int $p_annee): self
    {
        $this->p_annee = $p_annee;

        return $this;
    }

    public function getNbSessReq(): ?int
    {
        return $this->nb_sess_req;
    }

    public function setNbSessReq(?int $nb_sess_req): self
    {
        $this->nb_sess_req = $nb_sess_req;

        return $this;
    }

    public function getPathPhoto(): ?string
    {
        return $this->path_photo;
    }

    public function setPathPhoto(string $path_photo): self
    {
        $this->path_photo = $path_photo;

        return $this;
    }

    public function getPathCertif(): ?string
    {
        return $this->path_certif;
    }

    public function setPathCertif(string $path_certif): self
    {
        $this->path_certif = $path_certif;

        return $this;
    }

    public function getPathFiches(): ?string
    {
        return $this->path_fiches;
    }

    public function setPathFiches(string $path_fiches): self
    {
        $this->path_fiches = $path_fiches;

        return $this;
    }

    public function getPathFact(): ?string
    {
        return $this->path_fact;
    }

    public function setPathFact(string $path_fact): self
    {
        $this->path_fact = $path_fact;

        return $this;
    }

    public function getPathTeam(): ?string
    {
        return $this->path_team;
    }

    public function setPathTeam(string $path_team): self
    {
        $this->path_team = $path_team;

        return $this;
    }

    public function getLOGAP(): ?string
    {
        return $this->LOG_AP;
    }

    public function setLOGAP(string $LOG_AP): self
    {
        $this->LOG_AP = $LOG_AP;

        return $this;
    }

    public function getLOGDB(): ?string
    {
        return $this->LOG_DB;
    }

    public function setLOGDB(string $LOG_DB): self
    {
        $this->LOG_DB = $LOG_DB;

        return $this;
    }

    public function getLOGML(): ?string
    {
        return $this->LOG_ML;
    }

    public function setLOGML(string $LOG_ML): self
    {
        $this->LOG_ML = $LOG_ML;

        return $this;
    }

    public function getStatusInscriptions(): ?int
    {
        return $this->status_inscriptions;
    }

    public function setStatusInscriptions(int $status_inscriptions): self
    {
        $this->status_inscriptions = $status_inscriptions;

        return $this;
    }
}
