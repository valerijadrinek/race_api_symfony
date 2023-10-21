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

        $racerData = [];
        //array unique for ageCategoey field
        $unique = array_unique(array_column($arrayData, 'ageCategory'));


        //sorting arrays by time and field
        uasort($arrayData, function($a, $b) {
                         return strtotime($a['time']) - strtotime($b['time']); });
                   
        usort($arrayData, function($x, $y) {
            return strcasecmp($x['ageCategory'] , $y['ageCategory']);
         });

         //counting repetitive values as key(value from ageCategory column), value(number of repetitions)
        $countDataValues = array_count_values(array_column($arrayData, 'ageCategory'));

        //trying to solve a_g_placement
        foreach ($countDataValues as $key => $value) {
            foreach($arrayData as $data){
 //$i=1; while($key == $data['ageCategory'])-while is not working here - $data['age_category_placement'] = $i; $i++; 
                if($key == $data['ageCategory']) {
                    for($i = 1; $i < $value; $i++) {
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
                
            }
           
        }
        return $racerData;
   }

         

  
        
}



