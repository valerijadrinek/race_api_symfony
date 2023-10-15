<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Link;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\Repository\RaceResultRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;

use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Doctrine\Orm\Filter\OrderFilter;



#[ORM\Entity(repositoryClass: RaceResultRepository::class)]
#[ApiResource (shortName: 'Racers', 
               description: 'Racers that are running the race',
               operations: [
                new Get(
                    normalizationContext: [
                        'groups' => ['racers:read', 'racers:item:get'],
                    ]),
                new Put(),
                new Patch(),
                new Post(),
                new GetCollection()
            ],
               normalizationContext: [
                'groups' => ['racers:read'],
               ],
               denormalizationContext: [
                'groups' => ['racers:write'],
            ]
        
        ),
           ] 
#[ApiResource(
    uriTemplate: '/race/{id}/race-results.{_format}', 
    shortName: 'Racers',
    operations: [new GetCollection()],
    uriVariables: [
        'id' => new Link(
            fromClass: Race::class,
            fromProperty: 'racers'
        )
    ], 
   
    normalizationContext: [
        'groups' => ['racers:read'],
       ]
)]
#[ApiFilter(SearchFilter::class, properties: ['fullName' => 'partial', 'distance' => 'exact', 'ageCategory' => 'start' ])]
#[ApiFilter(OrderFilter::class, properties: ['fullName'=>'ASC', 'time'=>'DESC', 'distance'=>'ASC', 'ageCategory'=>'ASC' ], arguments: ['orderParameterName' => 'ord'])] //overall place & age category place
class RaceResult
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    #[Groups(['racers:read', 'racers:write', 'race:read', 'race:write'])]
    private ?string $fullName = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    #[Assert\Choice(['medium', 'long'], message:'Only medium or long distance is valid.')]
    #[Groups(['racers:read', 'racers:write','race:read', 'race:write'])]
    private ?string $distance = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    #[Groups(['racers:read', 'racers:write','race:read', 'race:write'])]
    private ?int $time = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    #[Groups(['racers:read', 'racers:write','race:read', 'race:write'])]
    private ?string $ageCategory = null;

    #[ORM\ManyToOne(inversedBy: 'racers')]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\Valid]
    #[Groups(['racers:read', 'racers:write'])]
    private ?Race $race = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['racers:read'])]
    private ?int $overall_placement = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['racers:read'])]
    private ?int $age_category_placement = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFullName(): ?string
    {
        return $this->fullName;
    }

    public function setFullName(string $fullName): static
    {
        $this->fullName = $fullName;

        return $this;
    }

    public function getDistance(): ?string
    {
        return $this->distance;
    }

    public function setDistance(string $distance): static
    {
        $this->distance = $distance;

        return $this;
    }

    public function getTime(): ?int
    {
        return $this->time;
    }

    public function setTime(int $time): static
    {
        $this->time = $time;

        return $this;
    }

    public function getAgeCategory(): ?string
    {
        return $this->ageCategory;
    }

    public function setAgeCategory(string $ageCategory): static
    {
        $this->ageCategory = $ageCategory;

        return $this;
    }

    public function getRace(): ?Race
    {
        return $this->race;
    }

    public function setRace(?Race $race): static
    {
        $this->race = $race;

        return $this;
    }

    public function getOverallPlacement(): ?int
    {
        return $this->overall_placement;   
    }

    public function setOverallPlacement(?int $overall_placement): static
    {
        if($this->distance === 'medium')
        {
            $this->overall_placement = null;
        } 

        $this->overall_placement = $overall_placement;
        return $this;    
            
        
        }
        

    public function getAgeCategoryPlacement(): ?int
    {
        return $this->age_category_placement;
    }

    public function setAgeCategoryPlacement(?int $age_category_placement): static
    {
         if($this->distance === 'medium') {
             $this->age_category_placement = null;
         }
        
        $this->age_category_placement = $age_category_placement;

        return $this;
    }


   
}
