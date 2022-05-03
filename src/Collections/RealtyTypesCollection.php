<?php
declare(strict_types=1);

namespace App\Collections;

use App\Enum\RealtyTypeEnum;
use App\Exceptions\ValueObjectConstraint;

final class RealtyTypesCollection extends \ArrayObject
{
    /**
     * @throws ValueObjectConstraint
     */
    public function append($value): void
    {
        if (!RealtyTypeEnum::accepts($value)) {
            throw new ValueObjectConstraint(sprintf("Value %s is not in Enumeration RealtyTypeEnum. (%s) are only allowed", $value, implode(", ", RealtyTypeEnum::values())));
        }
        parent::append($value);
    }
}