<?php

namespace App\Entity;

use ApiPlatform\Doctrine\Odm\Filter\SearchFilter;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use App\Controller\CreatePokemonController;
use App\Repository\PokemonRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: PokemonRepository::class)]
#[ApiResource(
    operations: [
        new Get(),
        new Post(),
        new GetCollection()
    ],
    normalizationContext: [
        'groups' => ['pokemon']
    ]
)]
//#[ApiFilter(SearchFilter::class, properties: ['name' => 'exact'])]
class Pokemon
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups('pokemon')]
    private ?string $name = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups('pokemon')]
    private ?string $url = null;

    #[ORM\Column(nullable: true)]
    #[Groups('pokemon')]
    private ?int $height = null;

    #[ORM\Column(nullable: true)]
    #[Groups('pokemon')]
    private ?int $weight = null;

    #[ORM\ManyToMany(targetEntity: Abilities::class, mappedBy: 'pokemon', cascade: ['persist'])]
    #[Groups('pokemon')]
    private Collection $abilities;

    #[ORM\ManyToMany(targetEntity: Types::class, mappedBy: 'pokemon', cascade: ['persist'])]
    #[Groups('pokemon')]
    private Collection $types;

    public function __construct()
    {
        $this->abilities = new ArrayCollection();
        $this->types = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(?string $url): self
    {
        $this->url = $url;

        return $this;
    }

    public function getHeight(): ?int
    {
        return $this->height;
    }

    public function setHeight(?int $height): self
    {
        $this->height = $height;

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

    /**
     * @return Collection<int, Abilities>
     */
    public function getAbilities(): Collection
    {
        return $this->abilities;
    }

    public function addAbility(Abilities $ability): self
    {
        if (!$this->abilities->contains($ability)) {
            $this->abilities->add($ability);
            $ability->addPokemon($this);
        }

        return $this;
    }

    public function removeAbility(Abilities $ability): self
    {
        if ($this->abilities->removeElement($ability)) {
            $ability->removePokemon($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Types>
     */
    public function getTypes(): Collection
    {
        return $this->types;
    }

    public function addType(Types $type): self
    {
        if (!$this->types->contains($type)) {
            $this->types->add($type);
            $type->addPokemon($this);
        }

        return $this;
    }

    public function removeType(Types $type): self
    {
        if ($this->types->removeElement($type)) {
            $type->removePokemon($this);
        }

        return $this;
    }
}
