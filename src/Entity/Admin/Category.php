<?php

namespace App\Entity\Admin;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\Admin\CategoryRepository")
 */
class Category
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
    private $GenderNo;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $Name;

    /**
     * @ORM\Column(type="string")
     */
    private $CreatedDate;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getGenderNo(): ?int
    {
        return $this->GenderNo;
    }

    public function setGenderNo(int $GenderNo): self
    {
        $this->GenderNo = $GenderNo;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->Name;
    }

    public function setName(string $Name): self
    {
        $this->Name = $Name;

        return $this;
    }

    public function getCreatedDate(): ?string
    {
        return $this->CreatedDate;
    }

    public function setCreatedDate(string $CreatedDate): self
    {
        $this->CreatedDate = $CreatedDate;

        return $this;
    }
}
