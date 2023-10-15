<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\GetCollection;

use App\Repository\RaceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;

use App\Dto\RaceRepresentation;
use App\Dto\RaceCollectionRepresentation;
use App\State\RaceRepresentationProvider;

use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Doctrine\Orm\Filter\OrderFilter;


#[ORM\Entity(repositoryClass: RaceRepository::class)]
#[ApiResource(shortName: 'Race', description: 'A representation of race and racers collection',
                operations: [
                    new Get(),
                    new Put(),
                    new Patch(),
                    new Post()
                ],
                normalizationContext: [
                        'groups' => ['race:read'],
                    ],
                denormalizationContext: [
                        'groups' => ['race:write'],
])]
##[Get(output: RaceRepresentation::class, provider: RaceRepresentationProvider::class)]//-POPRAVITI klasu
#[GetCollection(output: RaceCollectionRepresentation::class, provider: RaceCollectionProvider::class)]// isto
#[ApiFilter(OrderFilter::class, properties: ['title'=>'ASC', 'date'=>'DESC'], arguments: ['orderParameterName' => 'ord'])]//avg finish times


class Race
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    #[Groups(['race:read', 'race:write', 'racers:item:get'])]
    #[ApiFilter(SearchFilter::class, strategy:'partial')]
    private ?string $title = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Assert\NotBlank]
    #[Groups(['race:read', 'race:write'])]
    private ?\DateTimeInterface $date = null;

    #[ORM\OneToMany(mappedBy: 'race', targetEntity: RaceResult::class, cascade: ['persist'], orphanRemoval: true)]
    #[Assert\Valid]
    #[Groups(['race:read', 'race:write', 'racers:read'])]
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
    public function getRacers(): array
    {
        return $this->racers->getValues();
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
