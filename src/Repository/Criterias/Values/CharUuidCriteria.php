<?php
declare(strict_types=1);


namespace App\Repository\Criterias\Values;


use App\Entity\ValueObjects\AliasVO;
use App\Entity\ValueObjects\UuidVO;
use App\Exceptions\ValueObjectConstraint;
use App\Interfaces\AddCriteria;
use Doctrine\Common\Collections\Criteria;
use Doctrine\Common\Collections\ExpressionBuilder;
use Symfony\Component\Uid\Uuid;

final class CharUuidCriteria implements AddCriteria
{
    /**
     * @var UuidVO
     */
    private UuidVO $characteristicUuid;

    /**
     * @param UuidVO $characteristicUuid
     */
    public function __construct(UuidVO $characteristicUuid)
    {
        $this->characteristicUuid = $characteristicUuid;
    }

    /**
     * @param Criteria $criteria
     * @param ExpressionBuilder $expression
     * @return Criteria
     */
    public function addCriteria(Criteria $criteria, ExpressionBuilder $expression): Criteria
    {
        $criteria->andWhere($expression->eq('fkChar', $this->characteristicUuid->getValue()));

        return $criteria;
    }

}