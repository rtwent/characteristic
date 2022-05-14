<?php
declare(strict_types=1);


namespace App\Services\ValidationServices\CustomValidators;

use App\Services\ValidationServices\CustomValidators\ConstraintWithEntityManager;

/**
 * @Annotation
 *
 * @package App\Services\ValidationServices\CustomValidators
 */
final class ValueExistsInCharacteristic extends ConstraintWithEntityManager
{
    /**
     * @var string
     */
    public string $message = 'Vocabulary value with id "{{ valueId }}" does not belong to selected characteristic {{ characteristic }}';

}