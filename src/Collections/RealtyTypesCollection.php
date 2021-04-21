<?php
declare(strict_types=1);

namespace App\Collections;

use App\Enum\RealtyTypeEnum;
use App\Exceptions\ValueObjectConstraint;

final class RealtyTypesCollection extends \ArrayObject
{
    public function append($value): void
    {
        if (!RealtyTypeEnum::accepts($value)) {
            throw new ValueObjectConstraint(sprintf("Value %s is not in Enumeration RealtyTypeEnum", $value));
        }
        parent::append($value);
    }
}