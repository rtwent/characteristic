<?php
declare(strict_types=1);


namespace App\Repository\Criterias;

use \App\Interfaces\AddCriteria;
use Doctrine\Common\Collections\Criteria;
use Doctrine\Common\Collections\ExpressionBuilder;


final class CriteriasMerger
{
    private Criteria $criteria;

    private ?ExpressionBuilder $expression;


    public function __construct(Criteria $criteria)
    {
        $this->criteria = $criteria;
        $this->expression = Criteria::expr();
    }

    /**
     * @param AddCriteria $criteriaClass
     * @param null $data
     */
    public function add(AddCriteria $criteriaClass, $data = null)
    {
        if (!$criteriaClass instanceof AddCriteria) {
            throw new \InvalidArgumentException(sprintf("Instance of \App\Interfaces\AddCriteria expected. Instance of %s given", get_class($criteriaClass)));
        }
        $this->criteria = $criteriaClass->addCriteria($this->criteria, $this->expression);
    }

    /**
     * @return Criteria
     */
    public function getCriteria(): Criteria
    {
        return $this->criteria;
    }
}