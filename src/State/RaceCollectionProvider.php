<?php
namespace App\State;

use App\Entity\Race;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Dto\RaceCollectionRepresentation;

use ApiPlatform\Doctrine\Orm\State\CollectionProvider;

use ApiPlatform\Metadata\CollectionOperationInterface;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

final class RaceCollectionProvider implements ProviderInterface
{
    public function __construct(#[Autowire(service: CollectionProvider::class)] private ProviderInterface $collectionProvider )
    {
    }

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {
        if ($operation instanceof CollectionOperationInterface) {

            $this->collectionProvider->provide($operation, $uriVariables, $context);
            $newRepresentation = new RaceCollectionRepresentation(
                //popraviti
                $race->getFullname,
                $raceResult->getTime,
                $raceResult->getDistance,
                $raceResult->getAgeCategory,
                //overall place
                //age category place
            );
            return $newRepresentation;
        }
    }

}

