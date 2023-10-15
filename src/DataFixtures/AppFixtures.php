<?php

namespace App\DataFixtures;

use App\Factory\RaceFactory;
use App\Factory\RaceResultFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        RaceFactory::createMany(6);
        RaceResultFactory::createMany(40, function () {
            return [
                'race' => RaceFactory::random(),
            ];
        });

        
    }
}
