<?php
namespace App\Tests\Functional;

use App\Factory\RaceFactory;
use App\Factory\RaceResultFactory;
use Zenstruck\Browser\HttpOptions;
use Zenstruck\Browser\Test\HasBrowser;
use Zenstruck\Foundry\Test\ResetDatabase;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;


class TestRaceResultTest extends KernelTestCase
{
    use HasBrowser;
    use ResetDatabase;

    public function testCollectionRaceResalts() : void
    {
        RaceFactory::createMany(2);
        RaceResultFactory::createMany(15, function () {
           
            return [
                'race' => RaceFactory::random(),
            ];
        });

        $this->browser()
            ->get('/api/racers')
            // ->dump()
            ->assertJson()
            ->assertJsonMatches('"hydra:totalItems"', 15)
            ->assertJsonMatches('length("hydra:member")', 15)
            ->json()
        ;
    }

    public function testPostRaceResults() : void 
    {
        $race = RaceFactory::createOne();
        $this->browser()
            ->post('/api/racers', [
                'json' => [],
            ])
            ->assertStatus(422)
            ->post('/api/racers', HttpOptions::json([
                'fullName' => 'Jackie Jones',
                'distance' => 'medium',
                'time' => 1000,
                'ageCategory' => 'M25-30',
                'race' => '/api/races/'.$race->getId(),
            ])->withHeader('Accept', 'application/ld+json'))
            ->assertStatus(201)
            ->dump()
            ->assertJsonMatches('fullName', 'Jackie Jones')
            ;


    }
}