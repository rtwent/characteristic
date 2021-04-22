<?php


namespace App\Interfaces;

use Doctrine\Common\Collections\Criteria;
use Doctrine\Common\Collections\ExpressionBuilder;

/**
 * Interface GetCriteria
 * Getting criteria for querying
 * @package App\Interfaces
 */
interface AddCriteria
{
    public function addCriteria(Criteria $criteria, ExpressionBuilder $expression): Criteria;
}