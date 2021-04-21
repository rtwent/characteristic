<?php
declare(strict_types=1);

namespace App\Collections;

use App\Enum\RealtyTypeEnum;
use App\Enum\SearchCategoriesEnum;
use App\Exceptions\ValueObjectConstraint;

final class RealtyCategoriesCollection extends \ArrayObject
{
    public function append($value): void
    {
        if (!SearchCategoriesEnum::accepts($value)) {
            throw new ValueObjectConstraint(sprintf("Value %s is not in Enumeration SearchCategoriesEnum", $value));
        }
        parent::append($value);
    }
}