<?php
namespace App\Tests\Functional;


use Zenstruck\Browser\Test\HasBrowser;
use Zenstruck\Foundry\Test\ResetDatabase;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class TestRaceTest extends KernelTestCase 
{
    use HasBrowser;
    use ResetDatabase;

    public function testPostRaceTest(): void
    {
        $this->browser()
            ->post('/api/races', [
                'json' => [
                    'title' => 'New race on weekend',
                    'date' => '18.05.2023',
                ]
            ])
            
            ->assertStatus(201)
            //->dump()
           // ->assertJsonMatches('title', 'New race on weekend')
            ;
    }

}