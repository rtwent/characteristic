<?php
declare(strict_types=1);


namespace App\Services\ValidationServices\CustomValidators;

use App\Services\ValidationServices\CustomValidators\ConstraintWithEntityManager;

/**
 * @Annotation
 * Class CharacteristicExists
 * Is characteristic in the database
 *
 * @package App\Services\ValidationServices\CustomValidators
 */
final class CharacteristicExists extends ConstraintWithEntityManager
{
    /**
     * @var string
     */
    public string $message = 'Characteristic with id "{{ charId }}" was not found in database';

}