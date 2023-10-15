<?php
namespace App\Service;

use App\Repository\RaceRepository;
use App\Repository\RaceResultRepository;

class FilterService 
{
    public function __construct(private RaceRepository $raceRepository,
                                private RaceResultRepository $raceResultRepository
                                ) {

    }

    public function filterRace() 
    {
        
    }
}