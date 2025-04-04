<?php

namespace App\Entity;

use App\Repository\TransactionsRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TransactionsRepository::class)]
class Transactions
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    private ?string $amount = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $date = null;

    #[ORM\Column]
    private ?bool $status = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $ins_date = null;

    #[ORM\Column(length: 10)]
    private ?string $ins_uid = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $mod_date = null;

    #[ORM\Column(length: 10)]
    private ?string $mod_uid = null;


    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Products $product = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Clients $client = null;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAmount(): ?string
    {
        return $this->amount;
    }

    public function setAmount(string $amount): static
    {
        $this->amount = $amount;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): static
    {
        $this->date = $date;

        return $this;
    }

    public function isStatus(): ?bool
    {
        return $this->status;
    }

    public function setStatus(bool $status): static
    {
        $this->status = $status;

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

    public function getProduct(): ?Products
    {
        return $this->product;
    }

    public function setProduct(?Products $product): static
    {
        $this->product = $product;

        return $this;
    }

    public function getClient(): ?Clients
    {
        return $this->client;
    }

    public function setClient(?Clients $client): static
    {
        $this->client = $client;

        return $this;
    }
}
