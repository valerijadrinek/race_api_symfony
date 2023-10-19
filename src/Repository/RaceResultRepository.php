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

    public function add( array $array)
    {
        $em = $this->getEntityManager();
        $em->getConnection()->getConfiguration()->setMiddlewares([]); // DBAL 3


    

        // if($array) {
        // /**  @var RaceResult $entity */
        // $batchSize = 15;
        // for ($i = 1; $i <= 10000; ++$i) {
        //     $raceResult = new RaceResult;
        //     $raceResult->setFullName($i);
        //     $raceResult->setDistance($i);
        //     $raceResult->setTime($i);
        //     $raceResult->setAgeCategory($i);
        //     $em->persist($raceResult);
        //     if (($i % $batchSize) === 0) {
        //         $em->flush();
        //         $em->clear(); // Detaches all objects from Doctrine!
        //     }
        // }
        // $em->flush(); // Persist objects that did not make up an entire batch
        // $em->clear();

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
