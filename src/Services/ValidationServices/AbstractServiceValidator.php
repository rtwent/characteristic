<?php

namespace App\Services\ValidationServices;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class AbstractServiceValidator
 * @package App\Services\ValidationServices
 */
abstract class AbstractServiceValidator
{

    /**
     * @var ValidatorInterface
     */
    private ValidatorInterface $validation;

    /**
     * AbstractServiceValidator constructor.
     */
    public function __construct()
    {
        $this->validation = Validation::createValidator();
    }

    /**
     * @param array $data
     * @return array
     */
    public function validate(array $data): array
    {
        $result = [];

        $errors = $this->validation->validate($data, $this->rule());
        foreach ($errors as $error) {
            $result[] = sprintf("%s %s", $error->getPropertyPath(), $error->getMessage());
        }

        return $result;
    }

    /**
     * @return Assert\Collection
     */
    abstract public function rule(): Assert\Collection;
}