<?php

namespace App\Repository;

use App\Entity\Values;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Values|null find($id, $lockMode = null, $lockVersion = null)
 * @method Values|null findOneBy(array $criteria, array $orderBy = null)
 * @method Values[]    findAll()
 * @method Values[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ValuesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Values::class);
    }

}
