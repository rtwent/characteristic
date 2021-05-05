<?php

namespace App\Repository;

use App\dto\RepCharValuesOutDto;
use App\dto\UpsertCharValuesDto;
use App\Entity\Characteristics;
use App\Entity\Representation;
use App\Entity\RepresentationValues;
use App\Entity\ValueObjects\RepCharValuesCollectionVO;
use App\Exceptions\ValueObjectConstraint;
use App\Mappers\RepCharsEntityMapper;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

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

    public function create(UpsertCharValuesDto $dto): RepCharValuesOutDto
    {
        $entity = new RepresentationValues();
        $this->mutateEntity($entity, $dto);

        $this->getEntityManager()->persist($entity);
        $this->getEntityManager()->flush();

        return (new RepCharsEntityMapper($entity))->toDto();

    }

    public function update(int $id, UpsertCharValuesDto $dto)
    {
        $entity = $this->findOrFail($id);
        $this->mutateEntity($entity, $dto);
        $this->getEntityManager()->flush();
        return (new RepCharsEntityMapper($entity))->toDto();
    }

    private function findOrFail($id, $lockMode = null, $lockVersion = null): RepresentationValues
    {
        $entity = $this->find($id);
        if (\is_null($entity)) {
            throw new HttpException(Response::HTTP_NOT_FOUND, sprintf("Record with id %d was not found", $id));
        }

        return $entity;
    }

    /**
     * @param RepresentationValues $entity
     * @param UpsertCharValuesDto $dto
     * @throws ValueObjectConstraint
     */
    private function mutateEntity(RepresentationValues $entity, UpsertCharValuesDto $dto): void
    {
        $representation = $this->getEntityManager()->getRepository(Representation::class)
            ->findOrFail($dto->getRepresentation());
        $characteristic = $this->getEntityManager()->getRepository(Characteristics::class)
            ->findOrFail($dto->getCharacteristic());
        $entity->setRepresentation($representation);
        $entity->setCharacteristic($characteristic);
        $entity->setRepCharValues(new RepCharValuesCollectionVO($dto->getRepCharValues()->getArrayCopy()));
        $entity->setSettings($dto->getSettings());
    }

}
