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

    #[ORM\Column(type: Types::ARRAY, nullable: true)]
    private array $abilities = [];

    #[ORM\Column(nullable: true)]
    private ?int $heigth = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $name = null;

    #[ORM\Column(type: Types::ARRAY, nullable: true)]
    private array $stats = [];

    #[ORM\Column(type: Types::ARRAY, nullable: true)]
    private array $types = [];

    #[ORM\Column(nullable: true)]
    private ?int $base_experience = null;

    #[ORM\Column(type: Types::ARRAY, nullable: true)]
    private array $forms = [];

    #[ORM\Column(type: Types::ARRAY, nullable: true)]
    private array $game_indices = [];

    #[ORM\Column(type: Types::ARRAY, nullable: true)]
    private array $held_items = [];

    #[ORM\Column(nullable: true)]
    private ?bool $is_default = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $location_area_encounters = null;

    #[ORM\Column(type: Types::ARRAY, nullable: true)]
    private array $moves = [];

    #[ORM\Column(type: Types::OBJECT, nullable: true)]
    private ?object $species = null;

    #[ORM\Column(type: Types::OBJECT, nullable: true)]
    private ?object $sprites = null;

    #[ORM\Column(nullable: true)]
    private ?int $weight = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAbilities(): array
    {
        return $this->abilities;
    }

    public function setAbilities(?array $abilities): self
    {
        $this->abilities = $abilities;

        return $this;
    }

    public function getHeigth(): ?int
    {
        return $this->heigth;
    }

    public function setHeigth(?int $heigth): self
    {
        $this->heigth = $heigth;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getStats(): array
    {
        return $this->stats;
    }

    public function setStats(?array $stats): self
    {
        $this->stats = $stats;

        return $this;
    }

    public function getTypes(): array
    {
        return $this->types;
    }

    public function setTypes(?array $types): self
    {
        $this->types = $types;

        return $this;
    }

    public function getBaseExperience(): ?int
    {
        return $this->base_experience;
    }

    public function setBaseExperience(?int $base_experience): self
    {
        $this->base_experience = $base_experience;

        return $this;
    }

    public function getForms(): array
    {
        return $this->forms;
    }

    public function setForms(?array $forms): self
    {
        $this->forms = $forms;

        return $this;
    }

    public function getGameIndices(): array
    {
        return $this->game_indices;
    }

    public function setGameIndices(?array $game_indices): self
    {
        $this->game_indices = $game_indices;

        return $this;
    }

    public function getHeldItems(): array
    {
        return $this->held_items;
    }

    public function setHeldItems(?array $held_items): self
    {
        $this->held_items = $held_items;

        return $this;
    }

    public function isIsDefault(): ?bool
    {
        return $this->is_default;
    }

    public function setIsDefault(?bool $is_default): self
    {
        $this->is_default = $is_default;

        return $this;
    }

    public function getLocationAreaEncounters(): ?string
    {
        return $this->location_area_encounters;
    }

    public function setLocationAreaEncounters(?string $location_area_encounters): self
    {
        $this->location_area_encounters = $location_area_encounters;

        return $this;
    }

    public function getMoves(): array
    {
        return $this->moves;
    }

    public function setMoves(?array $moves): self
    {
        $this->moves = $moves;

        return $this;
    }

    public function getSpecies(): ?object
    {
        return $this->species;
    }

    public function setSpecies(?object $species): self
    {
        $this->species = $species;

        return $this;
    }

    public function getSprites(): ?object
    {
        return $this->sprites;
    }

    public function setSprites(?object $sprites): self
    {
        $this->sprites = $sprites;

        return $this;
    }

    public function getWeight(): ?int
    {
        return $this->weight;
    }

    public function setWeight(?int $weight): self
    {
        $this->weight = $weight;

        return $this;
    }
}
