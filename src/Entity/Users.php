<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class Users
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $Name;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $Surname;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $EMail;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $Password;

    /**
     * @ORM\Column(type="boolean")
     */
    private $Gender;

    /**
     * @ORM\Column(type="string", length=15)
     */
    private $BirthDate;

    /**
     * @ORM\Column(type="string", length=180)
     */
    private $Address;

    /**
     * @ORM\Column(type="boolean")
     */
    private $Authority;

    /**
     * @ORM\Column(type="string", length=15)
     */
    private $PhoneNumber;

    /**
     * @ORM\Column(type="datetime")
     */
    private $SavedDate;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getSurname(): ?string
    {
        return $this->Surname;
    }

    public function setSurname(string $Surname): self
    {
        $this->Surname = $Surname;

        return $this;
    }

    public function getEMail(): ?string
    {
        return $this->EMail;
    }

    public function setEMail(string $EMail): self
    {
        $this->EMail = $EMail;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->Password;
    }

    public function setPassword(string $Password): self
    {
        $this->Password = $Password;

        return $this;
    }

    public function getGender(): ?bool
    {
        return $this->Gender;
    }

    public function setGender(bool $Gender): self
    {
        $this->Gender = $Gender;

        return $this;
    }

    public function getBirthDate(): ?string
    {
        return $this->BirthDate;
    }

    public function setBirthDate(string $BirthDate): self
    {
        $this->BirthDate = $BirthDate;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->Address;
    }

    public function setAddress(string $Address): self
    {
        $this->Address = $Address;

        return $this;
    }

    public function getAuthority(): ?bool
    {
        return $this->Authority;
    }

    public function setAuthority(bool $Authority=false): self
    {
        $this->Authority = $Authority;

        return $this;
    }

    public function getPhoneNumber(): ?string
    {
        return $this->PhoneNumber;
    }

    public function setPhoneNumber(string $PhoneNumber): self
    {
        $this->PhoneNumber = $PhoneNumber;

        return $this;
    }

    public function getSavedDate(): ?\DateTimeInterface
    {
        return $this->SavedDate;
    }

    public function setSavedDate(\DateTimeInterface $SavedDate): self
    {
        $this->SavedDate = $SavedDate;

        return $this;
    }
}
