<?php
declare(strict_types=1);


namespace App\Services\ValidationServices\CustomValidators;

use App\Services\ValidationServices\CustomValidators\ConstraintWithEntityManager;

/**
 * @Annotation
 * Class CharacteristicExists
 * Is measure unit in the database
 *
 * @package App\Services\ValidationServices\CustomValidators
 */
final class MeasureUnitExists extends ConstraintWithEntityManager
{
    /**
     * @var string
     */
    public string $message = 'Measure unit with id "{{ measureUnitId }}" was not found in database';

}