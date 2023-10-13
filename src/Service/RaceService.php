<?php
namespace App\Service;

use App\Entity\Race;
use App\Repository\RaceRepository;
use App\Repository\RaceResultRepository;

class RaceService 
{
    public function __construct(private RaceRepository $raceRepository) {

    }
    public function getAllRace() 
    {
        return $this->raceRepository->getAllRaces();
    }

    public function getOneRace( Race $race) {
        return $this->raceRepository->getOneRace();
    }
}