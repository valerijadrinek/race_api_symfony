<?php

namespace App\Repository;

use App\Entity\RaceResult;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<RaceResult>
 *
 * @method RaceResult|null find($id, $lockMode = null, $lockVersion = null)
 * @method RaceResult|null findOneBy(array $criteria, array $orderBy = null)
 * @method RaceResult[]    findAll()
 * @method RaceResult[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RaceResultRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RaceResult::class);
    }

    public function add( array $arrayData)
    {
        $em = $this->getEntityManager();
        $em->getConnection()->getConfiguration()->setMiddlewares([]); // DBAL 3
     
     $batchSize = 20;
     for ($i = 1; $i <= 10000; ++$i) {
         $line = $arrayData[$i];
         $raceResult = new RaceResult();
         $raceResult->setFullName($line[0]);
         $raceResult->setDistance($line[1]);
         $raceResult->setTime($line[2]);
         $raceResult->setAgeCategory($line[3]);
         $raceResult->setOverallPlacement($line[4]);
         $raceResult->setAgeCategoryPlacement($line[5]);
         $em->persist($raceResult);
         if (($i % $batchSize) === 0) {
             $em->flush();
             $em->clear(); // Detaches all objects from Doctrine!
         }
     }
     $em->flush(); // Persist objects that did not make up an entire batch
     $em->clear();


    }
       
    

    public function remove(RaceResult $entity, bool $flush=false)
    {
        $this->getEntityManager()->remove($entity);

        if($flush) 
        {
            $this->getEntityManager()->flush();
        }
    }

    // public function deleteBulk(RaceResult $raceResult) : void
    // {
    //     $em = $this->getEntityManager();
    //     $q = $em->createQuery('delete from MyProject\Model\Manager m where m.salary > 100000');
    //     $numDeleted = $q->execute();
    // }

    // public function updateBulk(RaceResult $raceResult) : void
    // {
    //     $q = $em->createQuery('update MyProject\Model\Manager m set m.salary = m.salary * 0.9');
    //     $numUpdated = $q->execute();
    // }


//    /**
//     * @return RaceResult[] Returns an array of RaceResult objects
//     */



 }
