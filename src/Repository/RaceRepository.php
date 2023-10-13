<?php

namespace App\Repository;

use App\Entity\Race;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\QueryBuilder;

/**
 * @extends ServiceEntityRepository<Race>
 *
 * @method Race|null find($id, $lockMode = null, $lockVersion = null)
 * @method Race|null findOneBy(array $criteria, array $orderBy = null)
 * @method Race[]    findAll()
 * @method Race[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RaceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Race::class);
    }


    public function add(Race $entity, bool $flush=false)
    {
        $this->getEntityManager()->persist($entity);

        if($flush) 
        {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Race $entity, bool $flush=false)
    {
        $this->getEntityManager()->remove($entity);

        if($flush) 
        {
            $this->getEntityManager()->flush();
        }
    }

    public function getAllRaces():array
    {
        return $this->findAllQuery(
            withRacers:true,
            withAverageLong:true,
            withAverageMedium:true
        )
        ->orderBy('r.id', 'DESC')
        ->getQuery()->getResult(); 
    }

    public function getOneRace(int | Race $race) : array
    {
        return $this->findAllQuery(
            withRacers:true,
            withAverageLong:true,
            withAverageMedium:true
        )->where('r.id = :id')
        ->setParameter('id', $race instanceof Race ? $race->getId() : $race)
        ->getQuery()->getResult();
    }
    

    private function findAllQuery(
        bool $withRacers=false,
        bool $withAverageLong=false,
        bool $withAverageMedium=false
       
    ) : QueryBuilder 
    {
        $query = $this->createQueryBuilder('r');

        if($withRacers) {
            $query->leftJoin('r.race_result', 'c')
                  ->addSelect('c');
        }  
        
        if($withAverageLong) {
            $query->addSelect('avg(c.time) as avgLongTime')
            ->from('r', 'c')
            ->having('c.distance = long');
        }

        if($withAverageMedium) {
            $query->addSelect('avg(c.time) as avgMediumTime')
            ->from('r', 'c')
            ->having('c.distance = medium');
            
        }

      return $query;

    }

//    /**
//     * @return Race[] Returns an array of Race objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('r.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Race
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
