<?php
declare(strict_types=1);


namespace App\Repository\Criterias\Chars;


use App\Entity\ValueObjects\AliasVO;
use App\Exceptions\ValueObjectConstraint;
use App\Interfaces\AddCriteria;
use Doctrine\Common\Collections\Criteria;
use Doctrine\Common\Collections\ExpressionBuilder;
use Symfony\Component\Uid\Uuid;

final class AliasCriteria implements AddCriteria
{
    /**
     * @var array
     */
    private array $aliases;

    /**
     * @param array $aliases
     */
    public function __construct(array $aliases)
    {
        $this->aliases = $this->setAliases($aliases);
    }

    /**
     * @param Criteria $criteria
     * @param ExpressionBuilder $expression
     * @return Criteria
     */
    public function addCriteria(Criteria $criteria, ExpressionBuilder $expression): Criteria
    {
        $criteria->andWhere($expression->in('alias', $this->aliases));

        return $criteria;
    }

    /**
     * @param array $aliases
     * @return array
     */
    private function setAliases(array $aliases)
    {
        foreach ($aliases as $alias) {
            try {
                new AliasVO($alias);
            } catch (ValueObjectConstraint $e) {
                throw new \InvalidArgumentException(sprintf("Value %s is not valid alias", $alias));
            }
        }

        return $aliases;

    }
}