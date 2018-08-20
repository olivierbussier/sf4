<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EssaiRepository")
 */
class Essai
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="array", nullable=true)
     */
    private $myArray;

    public function getId()
    {
        return $this->id;
    }

    public function getMyArray(): ?array
    {
        return $this->myArray;
    }

    public function setMyArray(?array $myArray): self
    {
        $this->myArray = $myArray;

        return $this;
    }
}
