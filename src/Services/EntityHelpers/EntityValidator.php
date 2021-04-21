<?php
declare(strict_types=1);


namespace App\Services\EntityHelpers;

use App\Interfaces\Validatable;
use App\Exceptions\ValidationFail;
use Symfony\Component\Validator\Validator\ValidatorInterface;

final class EntityValidator
{
    /**
     * @var ValidatorInterface
     */
    private ValidatorInterface $validator;

    /**
     * EntityValidator constructor.
     * @param ValidatorInterface $validator
     */
    public function __construct(ValidatorInterface $validator)
    {
        $this->validator = $validator;
    }

    /**
     * @param Validatable $entity
     * @param null $constraints
     * @param null $groups e.g. ['groups' => 'groupName']
     */
    public function validateEntity(Validatable $entity, $constraints = null, $groups = null)
    {
        $errors = $this->validator->validate($entity, $constraints, $groups);

        if (count($errors) > 0) {
            throw new ValidationFail((string)$errors);
        }
    }
}