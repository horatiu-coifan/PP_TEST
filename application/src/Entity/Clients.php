<?php

namespace App\Entity;

use App\Repository\ClientsRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ClientsRepository::class)]
class Clients
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 16)]
    private ?string $cui = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $address = null;

    #[ORM\Column(length: 64, nullable: true)]
    private ?string $city = null;


    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $ins_date = null;

    #[ORM\Column(length: 10)]
    private ?string $ins_uid = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $mod_date = null;

    #[ORM\Column(length: 10)]
    private ?string $mod_uid = null;


    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Login $credentials = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?County $county = null;



    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCui(): ?string
    {
        return $this->cui;
    }

    public function setCui(string $cui): static
    {
        $this->cui = $cui;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(?string $address): static
    {
        $this->address = $address;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(?string $city): static
    {
        $this->city = $city;

        return $this;
    }


    public function getInsDate(): ?\DateTimeInterface
    {
        return $this->ins_date;
    }

    public function setInsDate(\DateTimeInterface $ins_date): static
    {
        $this->ins_date = $ins_date;

        return $this;
    }

    public function getInsUid(): ?string
    {
        return $this->ins_uid;
    }

    public function setInsUid(string $ins_uid): static
    {
        $this->ins_uid = $ins_uid;

        return $this;
    }

    public function getModDate(): ?\DateTimeInterface
    {
        return $this->mod_date;
    }

    public function setModDate(\DateTimeInterface $mod_date): static
    {
        $this->mod_date = $mod_date;

        return $this;
    }

    public function getModUid(): ?string
    {
        return $this->mod_uid;
    }

    public function setModUid(string $mod_uid): static
    {
        $this->mod_uid = $mod_uid;

        return $this;
    }

    public function getCredentials(): ?Login
    {
        return $this->credentials;
    }

    public function setCredentials(Login $credentials): static
    {
        $this->credentials = $credentials;

        return $this;
    }

    public function getCounty(): ?County
    {
        return $this->county;
    }

    public function setCounty(?County $county): static
    {
        $this->county = $county;

        return $this;
    }

}
