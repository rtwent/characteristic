<?php

namespace App\Repository;

use App\dto\UpsertValue;
use App\dto\ValueOutDto;
use App\Entity\Characteristics;
use App\Entity\ValueObjects\UuidVO;
use App\Entity\Values;
use App\Mappers\ValuesEntityMapper;
use App\Repository\Criterias\CriteriasMerger;
use App\Services\EntityHelpers\EntityValidator;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Query\QueryException;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

/**
 * @method Values|null find($id, $lockMode = null, $lockVersion = null)
 * @method Values|null findOneBy(array $criteria, array $orderBy = null)
 * @method Values[]    findAll()
 * @method Values[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ValuesRepository extends ServiceEntityRepository
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
        ManagerRegistry        $registry,
        EntityManagerInterface $entityManager,
        EntityValidator        $validator)
    {
        $this->validator = $validator;
        $this->entityManager = $entityManager;
        parent::__construct($registry, Values::class);
    }

    public function create(UpsertValue $value): ValueOutDto
    {
        $entity = new Values();
        $this->mutateEntity($entity, $value);

        return (new ValuesEntityMapper($entity))->toDto();
    }

    public function update(UpsertValue $value, UuidVO $uuid): ValueOutDto
    {
        $entity = $this->findOrFail($uuid);
        $this->mutateEntity($entity, $value);

        return (new ValuesEntityMapper($entity))->toDto();
    }

    public function remove(UuidVO $uuidVO): void
    {
        $entity = $this->findOrFail($uuidVO);
        $this->entityManager->remove($entity);
        $this->entityManager->flush();
    }

    public function findOrFail(UuidVO $uuidVO, $lockMode = null, $lockVersion = null): Values
    {
        $entity = $this->find($uuidVO->getValue(), $lockMode, $lockVersion);
        if (\is_null($entity)) {
            throw new HttpException(
                Response::HTTP_NOT_FOUND,
                sprintf("Active characteristic value with id %s was not found", $uuidVO->getValue())
            );
        }

        return $entity;
    }

    /**
     * @param CriteriasMerger $criterias
     * @return array
     * @throws QueryException
     */
    public function filter(CriteriasMerger $criterias): array
    {
        $qb = $this->createQueryBuilder('v')->addCriteria($criterias->getCriteria());
        return $qb->getQuery()->execute();
    }

    private function mutateEntity(Values $entity, UpsertValue $values): void
    {
        $characteristicEntity = $this->entityManager->getRepository(Characteristics::class)->findOrFail($values->getFkChar());

        $entity->setI18n($values->getI18n());
        $entity->setDefaultSort($values->getDefaultSort());
        $entity->setKey($values->getKey());
        $entity->setOnlyType($values->getOnlyType());
        $entity->setFkChar($characteristicEntity);

        $this->validator->validateEntity($entity);

        $this->entityManager->persist($entity);
        $this->entityManager->flush();
    }

}
