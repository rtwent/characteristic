<?php

namespace App\Repository;

use App\dto\RepCharValuesOutDto;
use App\dto\UpsertCharValuesDto;
use App\Entity\Characteristics;
use App\Entity\Representation;
use App\Entity\RepresentationValues;
use App\Entity\ValueObjects\RepCharValuesCollectionVO;
use App\Mappers\RepCharsEntityMapper;
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

    public function create(UpsertCharValuesDto $dto): RepCharValuesOutDto
    {
        $entity = new RepresentationValues();
        $representation = $this->getEntityManager()->getRepository(Representation::class)
            ->findOrFail($dto->getRepresentation());
        $characteristic = $this->getEntityManager()->getRepository(Characteristics::class)
            ->findOrFail($dto->getCharacteristic());
        $entity->setRepresentation($representation);
        $entity->setCharacteristic($characteristic);
        $entity->setRepCharValues(new RepCharValuesCollectionVO($dto->getRepCharValues()->getArrayCopy()));

        $this->getEntityManager()->persist($entity);
        $this->getEntityManager()->flush();

        return (new RepCharsEntityMapper($entity))->toDto();

    }

}
