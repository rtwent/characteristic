<?php
declare(strict_types=1);

namespace App\Collections;

use App\dto\CharOutDto;
use App\dto\MeasureUnitOutDto;
use App\Exceptions\ValueObjectConstraint;

final class MeasureUnitOutCollection extends \ArrayObject
{
    public function append($value): void
    {
        if (!$value instanceof MeasureUnitOutDto) {
            throw new ValueObjectConstraint("Instance of MeasureUnitOutDto expected");
        }
        parent::append($value);
    }
}