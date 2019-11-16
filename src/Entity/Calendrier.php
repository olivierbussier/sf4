<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CalendrierRepository")
 */
class Calendrier
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="date")
     */
    private $date;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $lieu;

    /**
     * @ORM\Column(type="string", length=8)
     */
    private $seanceMateriel;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $respMateriel;

    /**
     * @ORM\Column(type="string", length=8)
     */
    private $seanceBassin;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $respBassin;

    /**
     * @ORM\Column(type="string", length=8)
     */
    private $seanceGonflage;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $respGonflage;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $aideGonf1;

    /**
     * @ORM\Column(type="string", length=8)
     */
    private $aide1Validee;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $aideGonf2;

    /**
     * @ORM\Column(type="string", length=8)
     */
    private $aide2Validee;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $aideGonf3;

    /**
     * @ORM\Column(type="string", length=8)
     */
    private $aide3Validee;

    /**
     * @ORM\Column(type="string", length=8)
     */
    private $archive;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getLieu(): ?string
    {
        return $this->lieu;
    }

    public function setLieu(string $lieu): self
    {
        $this->lieu = $lieu;

        return $this;
    }

    public function getSeanceMateriel(): ?string
    {
        return $this->seanceMateriel;
    }

    public function setSeanceMateriel(string $seanceMateriel): self
    {
        $this->seanceMateriel = $seanceMateriel;

        return $this;
    }

    public function getRespMateriel(): ?string
    {
        return $this->respMateriel;
    }

    public function setRespMateriel(?string $respMateriel): self
    {
        $this->respMateriel = $respMateriel;

        return $this;
    }

    public function getSeanceBassin(): ?string
    {
        return $this->seanceBassin;
    }

    public function setSeanceBassin(string $seanceBassin): self
    {
        $this->seanceBassin = $seanceBassin;

        return $this;
    }

    public function getRespBassin(): ?string
    {
        return $this->respBassin;
    }

    public function setRespBassin(?string $respBassin): self
    {
        $this->respBassin = $respBassin;

        return $this;
    }

    public function getSeanceGonflage(): ?string
    {
        return $this->seanceGonflage;
    }

    public function setSeanceGonflage(string $seanceGonflage): self
    {
        $this->seanceGonflage = $seanceGonflage;

        return $this;
    }

    public function getRespGonflage(): ?string
    {
        return $this->respGonflage;
    }

    public function setRespGonflage(?string $respGonflage): self
    {
        $this->respGonflage = $respGonflage;

        return $this;
    }

    public function getAideGonf1(): ?string
    {
        return $this->aideGonf1;
    }

    public function setAideGonf1(?string $aideGonf1): self
    {
        $this->aideGonf1 = $aideGonf1;

        return $this;
    }

    public function getAide1Validee(): ?string
    {
        return $this->aide1Validee;
    }

    public function setAide1Validee(string $aide1Validee): self
    {
        $this->aide1Validee = $aide1Validee;

        return $this;
    }

    public function getAideGonf2(): ?string
    {
        return $this->aideGonf2;
    }

    public function setAideGonf2(?string $aideGonf2): self
    {
        $this->aideGonf2 = $aideGonf2;

        return $this;
    }

    public function getAide2Validee(): ?string
    {
        return $this->aide2Validee;
    }

    public function setAide2Validee(string $aide2Validee): self
    {
        $this->aide2Validee = $aide2Validee;

        return $this;
    }

    public function getAideGonf3(): ?string
    {
        return $this->aideGonf3;
    }

    public function setAideGonf3(?string $aideGonf3): self
    {
        $this->aideGonf3 = $aideGonf3;

        return $this;
    }

    public function getAide3Validee(): ?string
    {
        return $this->aide3Validee;
    }

    public function setAide3Validee(string $aide3Validee): self
    {
        $this->aide3Validee = $aide3Validee;

        return $this;
    }

    public function getArchive(): ?string
    {
        return $this->archive;
    }

    public function setArchive(?string $archive): self
    {
        $this->archive = $archive;

        return $this;
    }
}
