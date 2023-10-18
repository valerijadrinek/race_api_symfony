<?php

namespace App\State;


use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use ApiPlatform\Doctrine\Orm\State\ItemProvider;
use App\Dto\RaceRepresentation;
use Symfony\Component\DependencyInjection\Attribute\Autowire;


final class RaceRepresentationProvider implements ProviderInterface
{
    public function __construct(#[Autowire(service: ItemProvider::class)] private ProviderInterface $itemProviderprivate )
    {
    }
    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {
    

        /** @var $race Race */
        $race = $this->itemProviderprivate->provide($operation, $uriVariables, $context);

        if (!$race) {
            return null;
        }
        
        return $this->mapEntityToDto($race);
    }

    private function mapEntityToDto(object $race): object
    {
        //fetching race result
        $dto = new RaceRepresentation();
        $dto->title = $race->title();
        $dto->date = $race->date(); 

        $racerCollection = $race->racers();

        //extracting time & distance 
        $long = [];
        $medium = [];
        
        foreach ( $racerCollection as $racer ) {
            if ($racer['distance'] == "long") {
                $long[] = $racer['time'];
            } else {
                $medium[] =$racer['time'];
            }
        }
       //calculating avg time duration for all medium and long races
        $dto->averageTimeLong = $this->avgTime($long);
        $dto->averageTimeMedium = $this->avgTime($medium);
        $dto = new RaceRepresentation();
      
        return $dto;
    }
       
    private function avgTime(array $array)  //time interval array
    {
        $seconds = 0;
        foreach($array as $hours) {
        $exp = explode(':', strval($hours));
        $seconds += $exp[0]*3600 + $exp[1]*60 + $exp[2];
        }
        
        $averagTime = $seconds/sizeof( $array);
         
       return gmdate("H:i:s", $averagTime);

    }

    

    }
    
       
    

