<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SettingsRepository")
 */
class Settings
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $Title;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $Description;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Keywords;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $FirmName;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $Address;

    /**
     * @ORM\Column(type="string", length=15)
     */
    private $PhoneNumber;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $Facebook;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $Twitter;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $GooglePlus;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $Youtube;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getDescription(): ?string
    {
        return $this->Description;
    }

    public function setDescription(string $Description): self
    {
        $this->Description = $Description;

        return $this;
    }

    public function getKeywords(): ?string
    {
        return $this->Keywords;
    }

    public function setKeywords(string $Keywords): self
    {
        $this->Keywords = $Keywords;

        return $this;
    }

    public function getFirmName(): ?string
    {
        return $this->FirmName;
    }

    public function setFirmName(string $FirmName): self
    {
        $this->FirmName = $FirmName;

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

    public function getPhoneNumber(): ?string
    {
        return $this->PhoneNumber;
    }

    public function setPhoneNumber(string $PhoneNumber): self
    {
        $this->PhoneNumber = $PhoneNumber;

        return $this;
    }

    public function getFacebook(): ?string
    {
        return $this->Facebook;
    }

    public function setFacebook(string $Facebook): self
    {
        $this->Facebook = $Facebook;

        return $this;
    }

    public function getTwitter(): ?string
    {
        return $this->Twitter;
    }

    public function setTwitter(string $Twitter): self
    {
        $this->Twitter = $Twitter;

        return $this;
    }

    public function getGooglePlus(): ?string
    {
        return $this->GooglePlus;
    }

    public function setGooglePlus(string $GooglePlus): self
    {
        $this->GooglePlus = $GooglePlus;

        return $this;
    }

    public function getYoutube(): ?string
    {
        return $this->Youtube;
    }

    public function setYoutube(string $Youtube): self
    {
        $this->Youtube = $Youtube;

        return $this;
    }
}
