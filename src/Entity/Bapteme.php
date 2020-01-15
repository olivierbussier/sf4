<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

class Bapteme
{

    /**
     * @Assert\Email
     * @var string $email */
    private $email;

    /** @var \DateTime $date */
    private $date;

    private $baptise;

    public function __construct()
    {
        $this->baptise = new ArrayCollection();
    }

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

    public function getBaptise()
    {
        return $this->baptise;
    }
}
