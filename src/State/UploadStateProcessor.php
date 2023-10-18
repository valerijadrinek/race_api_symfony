<?php
namespace App\State;

use ApiPlatform\Doctrine\Common\State\PersistProcessor;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Entity\RaceResult;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

class UpdateStateProcessor implements ProcessorInterface
{
    public function __construct(
      #[Autowire(service: PersistProcessor::class)]
      private ProcessorInterface $innerProcessor)
    {
    }

    
    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): void
    {
      
      $this->innerProcessor->process($data, $operation, $uriVariables, $context);

      
        
        
        
}

}