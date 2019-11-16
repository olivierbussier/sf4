<?php

namespace App\Classes\Resa;

use App\Classes\Materiel\Resa;

class Reservation implements \Serializable {

    public $ref;
    public $refResa;
    public $items;
    public $dateSortie;
    public $dateRetour;
    public $typeSortie;
    public $nom;
    public $prenom;

    public function serialize()
    {
        $data = serialize([
            $this->ref,$this->refResa,$this->items,$this->dateSortie,$this->dateRetour,$this->typeSortie,
            $this->nom, $this->prenom
        ]);
        return $data;
    }

    public function unserialize($serialized)
    {
        $data = unserialize($serialized);
        list($this->ref,$this->refResa,$this->items,$this->dateSortie,$this->dateRetour,$this->typeSortie,
            $this->nom, $this->prenom) = $data;
    }

    /**
     * Reservation constructor.
     * @param Resa $resa
     * @throws \Exception
     */
    public function __construct()
    {
        $this->refResa    = null;
        $this->nbItems    = 0;
        $this->items      = [];
        $this->dateSortie = null;
        $this->dateRetour = null;
        $this->typeSortie = null;
    }
}

