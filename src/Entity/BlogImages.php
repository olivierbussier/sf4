<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\BlogImagesRepository")
 */
class BlogImages
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $ImageSrc;

    public function getId()
    {
        return $this->id;
    }

    public function getImageSrc(): ?string
    {
        return $this->ImageSrc;
    }

    public function setImageSrc(?string $ImageSrc): self
    {
        $this->ImageSrc = $ImageSrc;

        return $this;
    }
}
