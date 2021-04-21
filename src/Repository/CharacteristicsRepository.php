<?php

namespace App\Repository;

use App\dto\CharOutDto;
use App\dto\UpsertCharacteristic;
use App\Entity\Characteristics;
use App\Enum\CharsTypeEnum;
use App\Services\EntityHelpers\EntityValidator;
use App\Services\Locale\CurrentLanguage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Characteristics|null find($id, $lockMode = null, $lockVersion = null)
 * @method Characteristics|null findOneBy(array $criteria, array $orderBy = null)
 * @method Characteristics[]    findAll()
 * @method Characteristics[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CharacteristicsRepository extends ServiceEntityRepository
{
    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $entityManager;

    /**
     * @var EntityValidator
     */
    private EntityValidator $validator;

    public function __construct(
        ManagerRegistry $registry,
        EntityManagerInterface $entityManager,
        EntityValidator $validator)
    {
        $this->validator = $validator;
        $this->entityManager = $entityManager;
        parent::__construct($registry, Characteristics::class);
    }

    public function create(UpsertCharacteristic $characteristic): CharOutDto
    {
        $entity = new Characteristics();
        $entity->setAlias($characteristic->getAttrName()->getValue());
        $entity->setI18n($characteristic->getI18n());
        $entity->setProperty($characteristic->getSearchProperties());
        $entity->setType(CharsTypeEnum::get($characteristic->getFieldType()->getEnumValue()));

        $this->validator->validateEntity($entity);

        $this->entityManager->persist($entity);
        $this->entityManager->flush();

        $lang = CurrentLanguage::getInstance()->currentLang();

        return new CharOutDto(
            $entity->getId(),
            $entity->getAlias(),
            $entity->getType()->getValue(),
            $entity->getI18n()->singleLanguage($lang)->getLabel(),
            $entity->getI18n()->singleLanguage($lang)->getShort(),
            $entity->getProperty()->toArray()
        );
    }

    // /**
    //  * @return Characteristics[] Returns an array of Characteristics objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Characteristics
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
