<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\PokemonRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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
    private ?string $nom = null;



    #[ORM\Column(length: 30, nullable: true)]
    private ?string $evolution = null;

    #[ORM\Column(length: 30, nullable: true)]
    private ?string $prevolution = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $image = null;

    #[ORM\ManyToMany(targetEntity: Type::class, mappedBy: 'pokemon')]
    private Collection $types;

    #[ORM\ManyToOne(inversedBy: 'pokemon')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Talent $talent = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    public function __construct()
    {
        $this->types = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->Nom = $nom;

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

    /**
     * @return Collection<int, Type>
     */
    public function getTypes(): Collection
    {
        return $this->types;
    }

    public function addType(Type $type): self
    {
        if (!$this->types->contains($type)) {
            $this->types->add($type);
            $type->addPokemon($this);
        }

        return $this;
    }

    public function removeType(Type $type): self
    {
        if ($this->types->removeElement($type)) {
            $type->removePokemon($this);
        }

        return $this;
    }

    public function getTalent(): ?Talent
    {
        return $this->talent;
    }

    public function setTalent(?Talent $talent): self
    {
        $this->talent = $talent;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }
}
