<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\OrdersRepository")
 */
class Orders
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
    private $UserID;

    /**
     * @ORM\Column(type="float")
     */
    private $Total;

    /**
     * @ORM\Column(type="float")
     */
    private $Tax;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $PaymentType;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Note;

    /**
     * @ORM\Column(type="datetime")
     */
    private $CreatedAt;

    /**
     * @ORM\Column(type="boolean")
     */
    private $status;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUserID(): ?int
    {
        return $this->UserID;
    }

    public function setUserID(int $UserID): self
    {
        $this->UserID = $UserID;

        return $this;
    }

    public function getTotal(): ?float
    {
        return $this->Total;
    }

    public function setTotal(float $Total): self
    {
        $this->Total = $Total;

        return $this;
    }

    public function getTax(): ?float
    {
        return $this->Tax;
    }

    public function setTax(float $Tax): self
    {
        $this->Tax = $Tax;

        return $this;
    }

    public function getPaymentType(): ?string
    {
        return $this->PaymentType;
    }

    public function setPaymentType(string $PaymentType): self
    {
        $this->PaymentType = $PaymentType;

        return $this;
    }

    public function getNote(): ?string
    {
        return $this->Note;
    }

    public function setNote(string $Note): self
    {
        $this->Note = $Note;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->CreatedAt;
    }

    public function getStatus(): ?bool
    {
        return $this->status;
    }

    public function setStatus(bool $status): self
    {
        $this->status = $status;

        return $this;
    }
}
