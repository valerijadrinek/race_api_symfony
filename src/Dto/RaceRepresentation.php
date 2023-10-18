<?php
namespace App\Dto;



class RaceRepresentation  {

    public function __construct(public string $title,
                                public \DateTimeInterface $date,
                                public int $averageTimeMedium,
                                public int $averageTimeLong){

    }
 
}