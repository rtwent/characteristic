<?php
declare(strict_types=1);


namespace App\Services\ValidationServices\CustomValidators;

use App\Services\ValidationServices\CustomValidators\ConstraintWithEntityManager;

/**
 * @Annotation
 * Class RepresentationExists
 * Is representation in the database
 *
 * @package App\Services\ValidationServices\CustomValidators
 */
final class RepresentationExists extends ConstraintWithEntityManager
{
    /**
     * @var string
     */
    public string $message = 'Representation with id "{{ representationId }}" was not found in database';

}