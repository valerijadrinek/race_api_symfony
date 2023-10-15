<?php

namespace App\Controller;

use App\Entity\Race;
use App\Entity\RaceResult;
use App\Service\RaceService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


#[Route('/endpoint', name: 'app_race_')]
class RaceController extends AbstractController
{

    #[Route('/', name: 'index', methods: ['GET', 'HEAD'])] 
    public function index(RaceService $service): JsonResponse
    {

        $raceCollection = $service->getAllRace();
        return $this->json($raceCollection);
        
    }

    #[Route('/{race}', name: 'one', methods: ['GET', 'HEAD'])] 
    public function resultsByRace(Race $race, RaceService $service) : JsonResponse
    {
    
        $oneRace = $service->getOneRace($race);
        $jsonResponse = new JsonResponse();
        $jsonOneRace = $jsonResponse->setData($oneRace);

        return $this->render('endpoint/one.php', [
            'oneRace' => $jsonOneRace,
        ]);
    }

    #[Route('/{race}/{race-result}/edit', name: 'edit', methods: ['PUT', 'PATCH'])] 
    public function editRace(Race $race, RaceResult $raceResult, RaceService $raceService) : Response
    {
        $editSingleResult = $raceService->editSingle($raceResult);
        return $this->render('endpoint/edit.php', [
            'raceResult' => $raceResult,
        ]);
    } 
}

