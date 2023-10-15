<?php

namespace App\State;

use App\Entity\Race;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use ApiPlatform\Doctrine\Orm\State\ItemProvider;
use App\Dto\RaceRepresentation;
use Symfony\Component\DependencyInjection\Attribute\Autowire;


final class RaceRepresentationProvider implements ProviderInterface
{
    public function __construct(#[Autowire(service: ItemProvider::class)] private ProviderInterface $itemProviderprivate )
    {
    }
    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {
    

        /** @var $race Race */
        $race = $this->itemProviderprivate->provide($operation, $uriVariables, $context);
        
       
        return new RaceRepresentation(
            $race->getTitle,
            $race->getDate
            //average finish tine -medium and ordering filters
            //average finish tine -lomg
        );
    }
}
