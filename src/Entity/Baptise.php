<?php

namespace App\Entity;

class Baptise
{
    private $ident;
    private $nom;
    private $prenom;
    private $sexe;
    private $age;
    private $pointure;
    private $taille;

    /**
     * @return mixed
     */
    public function getIdent()
    {
        return $this->ident;
    }

    /**
     * @param mixed $ident
     */
    public function setIdent($ident): void
    {
        $this->ident = $ident;
    }

    /**
     * @return mixed
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * @param mixed $nom
     */
    public function setNom($nom): void
    {
        $this->nom = $nom;
    }

    /**
     * @return mixed
     */
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * @param mixed $prenom
     */
    public function setPrenom($prenom): void
    {
        $this->prenom = $prenom;
    }

    /**
     * @return mixed
     */
    public function getSexe()
    {
        return $this->sexe;
    }

    /**
     * @param mixed $sexe
     */
    public function setSexe($sexe): void
    {
        $this->sexe = $sexe;
    }

    /**
     * @return mixed
     */
    public function getAge()
    {
        return $this->age;
    }

    /**
     * @param mixed $age
     */
    public function setAge($age): void
    {
        $this->age = $age;
    }

    /**
     * @return mixed
     */
    public function getPointure()
    {
        return $this->pointure;
    }

    /**
     * @param mixed $pointure
     */
    public function setPointure($pointure): void
    {
        $this->pointure = $pointure;
    }

    /**
     * @return mixed
     */
    public function getTaille()
    {
        return $this->taille;
    }

    /**
     * @param mixed $taille
     */
    public function setTaille($taille): void
    {
        $this->taille = $taille;
    }
}
