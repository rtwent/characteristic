<?php

namespace App\Repository;

use App\dto\MeasureUnitOutDto;
use App\dto\UpsertMeasureUnit;
use App\Entity\MeasureUnits;
use App\Exceptions\ValueObjectConstraint;
use App\Mappers\MeasureUnitEntityMapper;
use App\Services\EntityHelpers\EntityValidator;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

/**
 * @method MeasureUnits|null find($id, $lockMode = null, $lockVersion = null)
 * @method MeasureUnits|null findOneBy(array $criteria, array $orderBy = null)
 * @method MeasureUnits[]    findAll()
 * @method MeasureUnits[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MeasureUnitsRepository extends ServiceEntityRepository
{
    /**
     * @var EntityValidator
     */
    private EntityValidator $validator;

    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $entityManager;

    public function __construct(
        ManagerRegistry $registry,
        EntityManagerInterface $entityManager,
        EntityValidator $validator)
    {
        $this->validator = $validator;
        $this->entityManager = $entityManager;
        parent::__construct($registry, MeasureUnits::class);
    }

    /**
     * @param UpsertMeasureUnit $dto
     * @return MeasureUnitOutDto
     * @throws ValueObjectConstraint
     */
    public function create(UpsertMeasureUnit $dto): MeasureUnitOutDto
    {
        $entity = new MeasureUnits();
        $this->mutateEntity($entity, $dto);
        return (new MeasureUnitEntityMapper($entity))->toDto();
    }

    /**
     * @param int $id
     * @param UpsertMeasureUnit $dto
     * @return MeasureUnitOutDto
     * @throws ValueObjectConstraint
     */
    public function update(int $id, UpsertMeasureUnit $dto): MeasureUnitOutDto
    {
        $entity = $this->find($id);
        $this->mutateEntity($entity, $dto);
        return (new MeasureUnitEntityMapper($entity))->toDto();
    }

    public function remove(int $id): void
    {
        $entity = $this->findOrFail($id);
        $this->entityManager->remove($entity);
        $this->entityManager->flush();
    }

    public function findOrFail(int $id, $lockMode = null, $lockVersion = null): MeasureUnits
    {
        $entity = $this->find($id, $lockMode, $lockVersion);
        if (\is_null($entity)) {
            throw new HttpException(
                Response::HTTP_NOT_FOUND,
                sprintf("Active characteristic with id %d was not found", $id)
            );
        }

        return $entity;
    }

    private function mutateEntity(MeasureUnits $entity, UpsertMeasureUnit $dto)
    {
        $entity->setSiName($dto->getSiName());
        $entity->setI18n($dto->getI18n());

        $this->validator->validateEntity($entity);

        $this->entityManager->persist($entity);
        $this->entityManager->flush();
    }

}
