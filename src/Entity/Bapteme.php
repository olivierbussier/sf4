<?php

namespace App\Entity;

use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormInterface;

class Bapteme
{

    /** @var string $email */
    private $email;

    /** @var string $date */
    private $date;

    /** @var Baptise[] $baptise  */
    private $baptise = [];

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail($email): void
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param string $date
     */
    public function setDate($date): void
    {
        $this->date = $date;
    }

    /**
     * @return Baptise[]
     */
    public function getBaptise(): array
    {
        return $this->baptise;
    }

    /**
     * @param Baptise[] $baptise
     * @param Form $f
     */
    public function addBaptise(array $baptise, FormInterface $f): void
    {
        $this->baptise[] = [
            'entity' => $baptise,
            'form'   => $f
        ];
    }
}
