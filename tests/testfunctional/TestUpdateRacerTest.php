<?php
namespace App\Tests\Functional;

use App\Factory\RaceResultFactory;
use Zenstruck\Browser\Test\HasBrowser;
use Zenstruck\Foundry\Test\ResetDatabase;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class TestUpdateRacerTest extends KernelTestCase  
{
    use HasBrowser;
    use ResetDatabase;

   public function testUpdateToPutchRacerTest() : void
   {
     $racer = RaceResultFactory::createOne();

     $this->browser()
          ->patch('/api/race/1/racers/'.$racer->getId(),
                 [
                    'json' => [
                        'fullName' => 'changed',
                    ],
                    'headers' => ['Content-Type' => 'application/merge-patch+json']
                 ]
                )
                ->assertStatus(200);
                ;


   }
}