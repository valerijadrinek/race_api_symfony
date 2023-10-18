<?php

namespace App\State;

use App\Entity\Race;
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
        $title = $race->getTitle();
        $date = $race->getDate();

        $racers = $race->getRacers();

       
        $averageTimeMedium = $this->avgTime($arrayMedium);
        $averageTimeLong = $this->avgTime($arrayLong);

        $dto = new RaceRepresentation($title, $date, $averageTimeMedium, $averageTimeLong);
      
        return $dto;
    }
       
    private function avgTime(array $array)  //moram dobiti array sa vremenima
    {
        $seconds = 0;
        foreach($array as $hours) {
        $exp = explode(':', strval($hours));
        $seconds += $exp[0]*3600 + $exp[1]*60 + $exp[2];
        }
        
        $averag = $seconds/sizeof( $array);
        
        
        
       return gmdate("H:i:s", $averag);

    }

    private function getTimetoArray($racers) 
    {
        $apps = [
            ['distance' => 'long', 'time' => 2],
            ['distance' => 'medium', 'time' => 1],
            ['distance' => 'long', 'time' => 3],
            ['distance' => 'medium', 'time' => 7],
            ['distance' => 'long', 'time' => 9]
        ];
        
        $long = [];
        $medium = [];
        
        foreach ( $apps as $var ) {
            if ($var['distance'] == "long") {
                $long[] = $var['time'];
            } else {
                $medium[] =$var['time'];
            }
        }
        
        print_r($long);
        print_r($medium);

        }

    }
    
       
    

