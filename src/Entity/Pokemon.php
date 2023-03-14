<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\PokemonRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PokemonRepository::class)]
#[ApiResource]
class Pokemon
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 30)]
    private ?string $Nom = null;

    #[ORM\Column(type: Types::ARRAY)]
    private array $Types = [];

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(type: Types::ARRAY)]
    private array $talents = [];

    #[ORM\Column(length: 30, nullable: true)]
    private ?string $evolution = null;

    #[ORM\Column(length: 30, nullable: true)]
    private ?string $prevolution = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $image = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->Nom;
    }

    public function setNom(string $Nom): self
    {
        $this->Nom = $Nom;

        return $this;
    }

    public function getTypes(): array
    {
        return $this->Types;
    }

    public function setTypes(array $Types): self
    {
        $this->Types = $Types;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getTalents(): array
    {
        return $this->talents;
    }

    public function setTalents(array $talents): self
    {
        $this->talents = $talents;

        return $this;
    }

    public function getEvolution(): ?string
    {
        return $this->evolution;
    }

    public function setEvolution(?string $evolution): self
    {
        $this->evolution = $evolution;

        return $this;
    }

    public function getPrevolution(): ?string
    {
        return $this->prevolution;
    }

    public function setPrevolution(?string $prevolution): self
    {
        $this->prevolution = $prevolution;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
    }
}
