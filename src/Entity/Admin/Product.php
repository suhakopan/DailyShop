<?php

namespace App\Entity\Admin;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\Admin\ProductRepository")
 */
class Product
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
    private $CategoryNo;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $Title;

    /**
     * @ORM\Column(type="integer")
     */
    private $Amount;

    /**
     * @ORM\Column(type="float")
     */
    private $Price;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $Description;

    /**
     * @ORM\Column(type="string", length=15)
     */
    private $SavedDate;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCategoryNo(): ?int
    {
        return $this->CategoryNo;
    }

    public function setCategoryNo(int $CategoryNo): self
    {
        $this->CategoryNo = $CategoryNo;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->Title;
    }

    public function setTitle(string $Title): self
    {
        $this->Title = $Title;

        return $this;
    }

    public function getAmount(): ?int
    {
        return $this->Amount;
    }

    public function setAmount(int $Amount): self
    {
        $this->Amount = $Amount;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->Price;
    }

    public function setPrice(float $Price): self
    {
        $this->Price = $Price;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->Description;
    }

    public function setDescription(string $Description): self
    {
        $this->Description = $Description;

        return $this;
    }

    public function getSavedDate(): ?string
    {
        return $this->SavedDate;
    }

    public function setSavedDate(string $SavedDate): self
    {
        $this->SavedDate = $SavedDate;

        return $this;
    }
}
