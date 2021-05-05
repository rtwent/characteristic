<?php
declare(strict_types=1);


namespace App\Repository\Criterias\Representations;


use App\Entity\ValueObjects\AliasVO;
use App\Entity\ValueObjects\UuidVO;
use App\Exceptions\ValueObjectConstraint;
use App\Interfaces\AddCriteria;
use Doctrine\Common\Collections\Criteria;
use Doctrine\Common\Collections\ExpressionBuilder;
use Symfony\Component\Uid\Uuid;

final class CharCriteria implements AddCriteria
{
    /**
     * @var UuidVO
     */
    private UuidVO $uuidVo;

    /**
     * @param UuidVO $uuidVo
     */
    public function __construct(UuidVO $uuidVo)
    {
        $this->uuidVo = $uuidVo;
    }

    /**
     * @param Criteria $criteria
     * @param ExpressionBuilder $expression
     * @return Criteria
     */
    public function addCriteria(Criteria $criteria, ExpressionBuilder $expression): Criteria
    {
        $criteria->andWhere($expression->eq('chars.id', $this->uuidVo->getValue()));

        return $criteria;
    }

}