<?php

namespace App\Repository;

use App\Entity\RepresentationValues;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method RepresentationValues|null find($id, $lockMode = null, $lockVersion = null)
 * @method RepresentationValues|null findOneBy(array $criteria, array $orderBy = null)
 * @method RepresentationValues[]    findAll()
 * @method RepresentationValues[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RepresentationValuesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RepresentationValues::class);
    }

    // /**
    //  * @return RepresentationValues[] Returns an array of RepresentationValues objects
    //  */
    /*
    public function findByExampleField($value)
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
    */

    /*
    public function findOneBySomeField($value): ?RepresentationValues
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
