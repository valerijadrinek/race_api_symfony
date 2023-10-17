<?php

namespace App\State;

use ApiPlatform\Doctrine\Common\State\PersistProcessor;
use App\Entity\Race;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Entity\RaceResult;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

class PlacementStateProcessor implements ProcessorInterface
{
    public function __construct(
      #[Autowire(service: PersistProcessor::class)]
      private ProcessorInterface $innerProcessor)
    {
    }

    
    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): void
    {
      $this->innerProcessor->process($data, $operation, $uriVariables, $context);

      if ($data instanceof RaceResult && $data->getDistance() === 'long') 
        {
            //$data;
            
          //calculate placement
        }
        
        
        
}

}