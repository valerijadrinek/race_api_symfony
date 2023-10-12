<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\RaceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: RaceRepository::class)]
#[ApiResource]

class Race
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    private ?string $title = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Assert\NotBlank]
    private ?\DateTimeInterface $date = null;

    #[ORM\OneToMany(mappedBy: 'race', targetEntity: RaceResult::class, orphanRemoval: true)]
    private Collection $racers;

    public function __construct()
    {
        $this->racers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

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

    /**
     * @return Collection<int, RaceResult>
     */
    public function getRacers(): Collection
    {
        return $this->racers;
    }

    public function addRacer(RaceResult $racer): static
    {
        if (!$this->racers->contains($racer)) {
            $this->racers->add($racer);
            $racer->setRace($this);
        }

        return $this;
    }

    public function removeRacer(RaceResult $racer): static
    {
        if ($this->racers->removeElement($racer)) {
            // set the owning side to null (unless already changed)
            if ($racer->getRace() === $this) {
                $racer->setRace(null);
            }
        }

        return $this;
    }
}
