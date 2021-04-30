<?php
declare(strict_types=1);


namespace App\Services\ValidationServices\CustomValidators;

use App\Services\ValidationServices\CustomValidators\ConstraintWithEntityManager;

/**
 * @Annotation
 * Class ValueExists
 * Is representation in the database
 *
 * @package App\Services\ValidationServices\CustomValidators
 */
final class ValueExists extends ConstraintWithEntityManager
{
    /**
     * @var string
     */
    public string $message = 'Characteristic value with id "{{ valueId }}" was not found in database';

}