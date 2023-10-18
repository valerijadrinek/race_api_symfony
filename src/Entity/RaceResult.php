<?php

namespace App\Entity;

use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Link;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Patch;
use App\State\PlacementStateProcessor;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use App\Repository\RaceResultRepository;
use ApiPlatform\Doctrine\Orm\Filter\OrderFilter;

use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\SerializedName;



#[ORM\Entity(repositoryClass: RaceResultRepository::class)]
#[ApiResource (shortName: 'Racers', 
               description: 'Racers that are running the {id} race',
               operations: [
                new Get(
                    normalizationContext: [
                        'groups' => ['racers:read' ],
                    ]),
                new Post(
                    processor: PlacementStateProcessor::class,
                ),
                new GetCollection(normalizationContext: [
                    'groups' => ['racers:read' ]
                ])
             
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
    uriTemplate: '/race/{race_id}/racers',
    shortName: 'Racers',
    operations: [new GetCollection()],
    uriVariables: [
        'race_id' => new Link(
            fromProperty: 'racers',
            fromClass: Race::class,
        ),
    ],
)]

#[ApiResource(
    uriTemplate: '/race/{race_id}/racers/{id}',
    shortName: 'Racers',
    uriVariables: [
        'race_id' => new Link(
            fromProperty: 'racers',
            fromClass: Race::class,
        ),
        'id' => new Link(
            fromClass: RaceResult::class,
        )            
        
            
    ],
    operations: [
        new Get(
            normalizationContext: [
                'groups' => [ 'racers:read'],
               ],
        ),
        
            new Patch(
                normalizationContext: [
                    'groups' => [ 'race:read'],
                   ],
                denormalizationContext: [
                    'groups' => ['racers:write']
                ]
            )],
    
)]


   
#[ApiFilter(SearchFilter::class, properties: ['fullName' => 'partial', 'distance' => 'exact', 'ageCategory' => 'start' ])]
#[ApiFilter(OrderFilter::class, properties: ['fullName', 'finishTime'=>'DESC', 'distance'=>'ASC', 'ageCategory', 'overallPlacement', 'ageCategoryPlace'  ], arguments: ['orderParameterName' => 'ord'])] 

class RaceResult
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups('racers:read', 'race:read')]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    #[Groups(['racers:read', 'racers:write', 'race:read'])]
    private ?string $fullName = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    #[Assert\Choice(['medium', 'long'], message:'Only medium or long distance is valid.')]
    #[Groups(['racers:read', 'racers:write','race:read'])]
    private ?string $distance = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    #[Groups(['racers:read', 'racers:write','race:read'])]
    private ?string $time = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    #[Groups(['racers:read', 'racers:write','race:read'])]
    private ?string $ageCategory = null;

    #[ORM\ManyToOne(inversedBy: 'racers')]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\Valid]
    #[Groups(['racers:read', 'race:write'])]
    private ?Race $race = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['racers:read','racers:write', 'race:read'])]
    #[SerializedName('Overall Placement')]
    /**
     * @var int Non-persisted
     * */
    private ?int $overall_placement = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['racers:read','racers:write', 'race:read'])]
    #[SerializedName('Age Category Placement')]
    /**
     * @var int Non-persisted
     * */
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

    public function getTime(): ?string
    {
        return $this->time;
    }

    public function setTime(?string $time): static
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


    private function calculatePlacement($time)
{
    
    $csvTimes = [];
    $csvTimes[] = $time;

    foreach ($csvTimes as $csvTime) {
        date_parse_from_format("H:i:s", $csvTime);     
        
    }

    
   

}
    

    


   
}
