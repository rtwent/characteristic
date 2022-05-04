<?php

namespace App\Repository;

use App\dto\RepCharValuesOutDto;
use App\dto\UpsertCharValuesDto;
use App\Entity\Characteristics;
use App\Entity\Representation;
use App\Entity\RepresentationValues;
use App\Entity\ValueObjects\RepCharValuesCollectionVO;
use App\Exceptions\ValueObjectConstraint;
use App\Exceptions\WrongRequest;
use App\Mappers\RepCharsEntityMapper;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * @method RepresentationValues|null find($id, $lockMode = null, $lockVersion = null)
 * @method RepresentationValues|null findOneBy(array $criteria, array $orderBy = null)
 * @method RepresentationValues[]    findAll()
 * @method RepresentationValues[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RepresentationValuesRepository extends ServiceEntityRepository
{
    private ValidatorInterface $validator;

    public function __construct(ManagerRegistry $registry, ValidatorInterface $validator)
    {
        $this->validator = $validator;
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

    public function update(int $id, UpsertCharValuesDto $dto): RepCharValuesOutDto
    {
        $entity = $this->findOrFail($id);
        $this->mutateEntity($entity, $dto);
        $this->getEntityManager()->flush();
        return (new RepCharsEntityMapper($entity))->toDto();
    }

    public function delete(int $id): void
    {
        $entity = $this->findOrFail($id);
        $this->getEntityManager()->remove($entity);
        $this->getEntityManager()->flush();
    }

    private function findOrFail(int $id, $lockMode = null, $lockVersion = null): RepresentationValues
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

        $errors = $this->validator->validate($entity);

        if (count($errors) > 0) {
            $message = "";
            foreach ($errors as $key => $error) {
                $message .= $error->getMessage();
            }
            throw new WrongRequest($message, null, [], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

    }

}
