<?php
declare(strict_types=1);


namespace App\Entity\ValueObjects;


use App\Exceptions\ValueObjectConstraint;

abstract class BaseValueObject
{
    protected function filterEmptyParam(string $value, string $paramName = ""): string
    {
        if (empty($value)) {
            throw new ValueObjectConstraint(sprintf("Value of parameter %s can not be empty", $paramName));
        }

        return $value;
    }
}