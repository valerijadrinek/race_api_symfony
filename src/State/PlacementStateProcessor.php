<?php

namespace App\State;

use App\Entity\RaceResult;
use ApiPlatform\Metadata\Operation;
use App\Repository\RaceResultRepository;
use ApiPlatform\State\ProcessorInterface;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\CsvEncoder;
use ApiPlatform\Doctrine\Common\State\PersistProcessor;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Normalizer\ArrayDenormalizer;


class PlacementStateProcessor implements ProcessorInterface
{
    public function __construct(
      #[Autowire(service: PersistProcessor::class)]
      private ProcessorInterface $innerProcessor, 
      private RaceResultRepository $raceResultRepository
     )
    {
    }

    
    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): void
    {

        $encodedData = $this->encodingCsv($data);
        $overallcalculatedArray = $this->calculateOverallPlacement($encodedData);
        $agecategorycallculatedArray = $this->calculateAgeCategoryPlacement($overallcalculatedArray);
        
        

       
    
        $this->innerProcessor->process($overallcalculatedArray, $operation, $uriVariables, $context);
     
     
     
    }

    private function encodingCsv($arrayData):array
    {
       //csv file parsimg
       $encoder = [new CsvEncoder([CsvEncoder::DELIMITER_KEY => ','])];
       $normalizer = [new ObjectNormalizer(), new ArrayDenormalizer()];
       $serializer = new Serializer($normalizer, $encoder);
       $output = $serializer->decode($arrayData,'csv');
       return $output;
    } 

   private function calculateOverallPlacement(array $arrayData):array
   {
    
       uasort($arrayData, function($a, $b) {
           return strtotime($a['time']) - strtotime($b['time']);
       });
       //initialiying new array
       $racerData = array();

        // iterate the field and access the same indexes from the other fields
        for($i = 1; $i < count($arrayData); $i++) {
            $racerData = [ 
                'fullName' => $arrayData[$i]['fullName'],
                'distance' => $arrayData[$i]['distance'],
                'time' => $arrayData[$i]['time'],
                'ageCategory' => $arrayData[$i]['ageCategory'],
                'overall_placement'=>$i
            ];
        }
        return $racerData;
    
   }

   private function calculateAgeCategoryPlacement(array $arrayData):array
   {
    $uniquearray = array_unique($arrayData);
        
    $racersData = [];
    
    //matching values from uniquearray and arrayData
    foreach($uniquearray as $value) {

        if(in_array($value, $arrayData)) {
            //combining them to new array
           $times = [//here goes all the data from matching array
        ]; 
           
            //sorting
            uasort($times, function($a, $b) {
                return strtotime($a['time']) - strtotime($b['time']); 
            });
            
        //initialiying new array with age category placements
            $racerData = [];
    
            // iterate the field and access the same indexes from the other fields
            for($i = 1; $i < count($arrayData); $i++) {
                $racerData =[ 
                    'fullName' => $arrayData[$i]['fullName'],
                    'distance' => $arrayData[$i]['distance'],
                    'time' => $arrayData[$i]['time'],
                    'ageCategory' => $arrayData[$i]['ageCategory'],
                    'overall_placement'=>$arrayData['overall_placement'],
                    'age_category_placement' =>$i
                ];
            }

        
         }

         return $racerData;
        };
       
    }

   


  
        
}



