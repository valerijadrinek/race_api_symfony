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
     //csv file parsimg
     $encoder = [new CsvEncoder([CsvEncoder::DELIMITER_KEY => ','])];
     $normalizer = [new ObjectNormalizer()];
     $serializer = new Serializer($normalizer, $encoder);
     $output = $serializer->decode($data,'csv');
     

     //izračunati vrijednosti
     foreach ($output as $key => $value) {
      
     }



     //ubaciti ih u array
     //na redu dolazi upload
     $em = $this->raceResultRepository->getEntityManager();
     $em->getConnection()->getConfiguration()->setMiddlewares([]); // DBAL 3
     $batchSize = 20;
     for ($i = 1; $i <= 10000; ++$i) {
         $raceResult = new RaceResult;
         $raceResult->setFullName($i);
         $raceResult->setDistance($i);
         $raceResult->setTime($i);
         $raceResult->setAgeCategory($i);
         $raceResult->setOverallPlacement($i);
         $raceResult->setAgeCategoryPlacement($i);
         $em->persist($raceResult);
         if (($i % $batchSize) === 0) {
             $em->flush();
             $em->clear(); // Detaches all objects from Doctrine!
         }
     }
     $em->flush(); // Persist objects that did not make up an entire batch
     $em->clear();
    }

      // if ($data === 'long') 
      //   {
      //       //$data;
            
      //     //calculate placement
      //   }

      //   $this->innerProcessor->process($data, $operation, $uriVariables, $context);
              
        
}



