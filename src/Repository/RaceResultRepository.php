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

    public function add(array $entityArray, bool $flush=false)
    {
        /**  @var RaceResult $entity */
        foreach($entityArray as $entity) {
        $this->getEntityManager()->persist($entity);
        }

        if($flush) 
        {
            $this->getEntityManager()->flush();
        }

       
    }

    public function remove(RaceResult $entity, bool $flush=false)
    {
        $this->getEntityManager()->remove($entity);

        if($flush) 
        {
            $this->getEntityManager()->flush();
        }
    }




//    /**
//     * @return RaceResult[] Returns an array of RaceResult objects
//     */
   public function findByExampleField($value): array
   {
       return $this->createQueryBuilder('r')
           ->andWhere('r.exampleField = :val')
           ->setParameter('val', $value)
           ->orderBy('r.id', 'ASC')
           ->setMaxResults(10)
           ->getQuery()
           ->getResult()
       ;
   }

   public function findOneBySomeField($value): ?RaceResult
   {
       return $this->createQueryBuilder('r')
           ->andWhere('r.exampleField = :val')
           ->setParameter('val', $value)
           ->getQuery()
           ->getOneOrNullResult()
       ;
   }
}
