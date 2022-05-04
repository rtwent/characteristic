<?php

namespace App\Repository;

use App\dto\ValuesBySearchCategories;
use App\Entity\Representation;
use App\Entity\ValueObjects\RealtyTypeVO;
use App\Entity\ValueObjects\UuidVO;
use App\Repository\Criterias\CriteriasMerger;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\Query\QueryException;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

/**
 * @method Representation|null find($id, $lockMode = null, $lockVersion = null)
 * @method Representation|null findOneBy(array $criteria, array $orderBy = null)
 * @method Representation[]    findAll()
 * @method Representation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RepresentationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Representation::class);
    }

    public function repCharValues(UuidVO $uuidVO): Representation
    {
        $qb = $this->getBaseDQlQuery();
        $qb->where('rep.id = ?1')->setParameter(1, $uuidVO->getValue());

        return $this->findOrFailByQueryBuilder($qb);
    }

    /**
     * @param CriteriasMerger $criterias
     * @return Representation
     * @throws NonUniqueResultException
     * @throws QueryException
     */
    public function valuesByCharacteristic(CriteriasMerger $criterias)
    {
        $qb = $this->getBaseDQlQuery();
        $qb->addCriteria($criterias->getCriteria());

        return $this->findOrFailByQueryBuilder($qb);
    }

    public function valuesBySearchCategory(ValuesBySearchCategories $dto, CriteriasMerger $criterias): Representation
    {
        $qb = $this->getBaseDQlQuery();
        $qb->addCriteria($criterias->getCriteria());
        $qb->andWhere("
            JSONB_CONTAINS(
                JSON_GET( JSON_GET(chars.property, 'search'), 'categories' ),
                ?1
            ) = true
        ")->setParameter(1, sprintf('["%s"]', $dto->getSearchCategory()->getValue()));

        if (!is_null($dto->getRealtyType())) {
            $qb->andWhere("
                JSONB_CONTAINS(
                JSON_GET( JSON_GET(chars.property, 'search'), 'types' ),
                ?2
            ) = true
            ")->setParameter(2, sprintf('["%s"]', $dto->getRealtyType()->getValue()));
        }

        return $this->findOrFailByQueryBuilder($qb);
    }

    public function repCharValuesByRealtyType(UuidVO $uuidVO, RealtyTypeVO $realtyTypeVO): Representation
    {
        $qb = $this->getBaseDQlQuery();
        $qb->where('rep.id = ?1')->setParameter(1, $uuidVO->getValue());

        $jsonbRealtyType = sprintf('["%s"]', $realtyTypeVO->getValue());
        $qb->andWhere("
            JSONB_CONTAINS(
                JSON_GET( JSON_GET(chars.property, 'search'), 'types' ),
                ?2
            ) = true
         ")->setParameter(2, $jsonbRealtyType);

        $qb->andWhere("
            JSONB_CONTAINS(
                values.onlyType, ?3
            ) = true
        ")->setParameter(3, $jsonbRealtyType);

        return $this->findOrFailByQueryBuilder($qb);
    }

    /**
     * @param UuidVO $uuidVO
     * @param null $lockMode
     * @param null $lockVersion
     * @return Representation
     */
    public function findOrFail(UuidVO $uuidVO, $lockMode = null, $lockVersion = null): Representation
    {
        $entity = $this->find($uuidVO->getValue(), $lockMode, $lockVersion);
        if (\is_null($entity)) {
            throw new HttpException(
                Response::HTTP_NOT_FOUND,
                sprintf("Active representation with id %s was not found", $uuidVO->getValue())
            );
        }

        return $entity;
    }

    /**
     * @param QueryBuilder $qb
     * @return Representation
     * @throws NonUniqueResultException
     */
    private function findOrFailByQueryBuilder(QueryBuilder $qb): Representation
    {
        $representation = $qb->getQuery()->getOneOrNullResult();
        if (\is_null($representation)) {
            throw new HttpException(Response::HTTP_NOT_FOUND, "Representation or bound to representation entity was not found");
        }

        return $representation;
    }

    /**
     * Base query
     * @return QueryBuilder
     */
    private function getBaseDQlQuery(): QueryBuilder
    {
        $qb = $this->getEntityManager()->createQueryBuilder('rep');
        $qb->select('rep', 'repValues', 'chars', 'values')
            ->from(Representation::class, 'rep')
            ->innerJoin('rep.repCharacteristics', 'repValues')
            ->innerJoin('repValues.characteristic', 'chars')
            ->innerJoin('chars.values', 'values');

        return $qb;
    }

}
