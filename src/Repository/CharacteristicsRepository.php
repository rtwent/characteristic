<?php

namespace App\Repository;

use App\dto\CharFilter;
use App\dto\CharOutDto;
use App\dto\UpsertCharacteristic;
use App\Entity\Characteristics;
use App\Entity\ValueObjects\UuidVO;
use App\Enum\CharsTypeEnum;
use App\EventSubscriber\LocaleSetter;
use App\Mappers\CharacteristicEntityMapper;
use App\Repository\Criterias\CriteriasMerger;
use App\Services\EntityHelpers\EntityValidator;
use App\Services\Locale\CurrentLanguage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Query\QueryException;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Uid\Uuid;

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

    /**
     * Filtering records, based on criterias from service and if...else on json fields
     * @param CharFilter $dto
     * @param CriteriasMerger $criterias
     * @return array
     * @throws QueryException
     */
    public function filter(CharFilter $dto, CriteriasMerger $criterias): array
    {
        $lang = CurrentLanguage::getInstance()->currentLang();

        $qb = $this->createQueryBuilder('c')
            ->addCriteria($criterias->getCriteria());

        foreach ($dto->getLabels() as $key => $label) {
            $qb->andWhere("UPPER(JSON_GET_TEXT(JSON_GET(c.i18n, '" . $lang . "'), 'label')) like '%" . mb_strtoupper($label, 'utf-8') . "%'");
        }

        return $qb->getQuery()->execute();
    }

    public function findOrFail(string $id, $lockMode = null, $lockVersion = null): Characteristics
    {
        $entity = $this->find($id, $lockMode, $lockVersion);
        if (\is_null($entity)) {
            throw new HttpException(
                Response::HTTP_NOT_FOUND,
                sprintf("Active characteristic with id %s was not found", $id)
            );
        }

        return $entity;
    }

    public function update(UpsertCharacteristic $characteristic, UuidVO $uuidVO): CharOutDto
    {
        $entity = $this->findOrFail($uuidVO->getValue());
        $this->mutateEntity($entity, $characteristic);

        return (new CharacteristicEntityMapper($entity))->toDto();
    }

    public function remove(UuidVO $uuidVO): void
    {
        $entity = $this->findOrFail($uuidVO->getValue());
        $this->entityManager->remove($entity);
        $this->entityManager->flush();
    }

    private function mutateEntity(Characteristics $entity, UpsertCharacteristic $characteristic): void
    {
        $entity->setAlias($characteristic->getAttrName()->getValue());
        $entity->setI18n($characteristic->getI18n());
        $entity->setProperty($characteristic->getSearchProperties());
        $entity->setType(CharsTypeEnum::get($characteristic->getFieldType()->getEnumValue()));

        $this->validator->validateEntity($entity);

        $this->entityManager->persist($entity);
        $this->entityManager->flush();
    }

    public function create(UpsertCharacteristic $characteristic): CharOutDto
    {
        $entity = new Characteristics();
        $this->mutateEntity($entity, $characteristic);

        return (new CharacteristicEntityMapper($entity))->toDto();
    }

}
