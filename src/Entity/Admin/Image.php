<?php

namespace App\Entity\Admin;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\Admin\ImageRepository")
 */
class Image
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
    private $ProductNo;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $ImageSource;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProductNo(): ?int
    {
        return $this->ProductNo;
    }

    public function setProductNo(int $ProductNo): self
    {
        $this->ProductNo = $ProductNo;

        return $this;
    }

    public function getImageSource(): ?string
    {
        return $this->ImageSource;
    }

    public function setImageSource(string $ImageSource): self
    {
        $this->ImageSource = $ImageSource;

        return $this;
    }
}
