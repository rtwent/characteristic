<?php
declare(strict_types=1);


namespace App\Services\ValidationServices\CustomValidators;


use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Constraint;

/**
 * Constraints that give access to entity manager for validation rules
 *
 * Class ConstraintWithEntityManager
 * @package App\Services\ValidationServices\CustomValidators
 */
abstract class ConstraintWithEntityManager extends Constraint
{
    /**
     * @var EntityManagerInterface|mixed
     */
    private EntityManagerInterface $entityManager;

    /**
     * ServiceExists constructor.
     * @param $options
     */
    public function __construct($options)
    {
        if (isset($options['entityManager']) && $options['entityManager'] instanceof EntityManagerInterface) {
            $this->entityManager = $options['entityManager'];
        }
//        unset($options['entityManager']);
//        parent::__construct($options);
    }

    /**
     * @return EntityManagerInterface
     */
    public function getEntityManager(): EntityManagerInterface
    {
        return $this->entityManager;
    }
}