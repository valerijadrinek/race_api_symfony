<?php

namespace App\Controller;

use App\Entity\Race;
use App\Service\RaceService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

#[Route('/race', name: 'app_race_')]
class RaceController extends AbstractController
{

    #[Route('/', name: 'index')] 
    public function index(RaceService $service): JsonResponse
    {
        $raceCollection = $service->getAllRace() ;
        return $this->render('race/index.html.twig', [
            'raceCollection' => $raceCollection,
        ]);
    }

    #[Route('/{race}', name: 'one')] 
    public function resultsByRace(Race $race, RaceService $service) : JsonResponse
    {
    
        $oneRace = $service->getOneRace($race);

        return $this->render('race/one.html.twig', [
            'oneRace' => $oneRace,
        ]);
    }

    #[Route('/{race}/edit', name: 'edit')] 
    public function editRace(Race $race) : Response
    {
        return $this->render('race/edit.html.twig', [
            'race' => $race,
        ]);
    } 
}
