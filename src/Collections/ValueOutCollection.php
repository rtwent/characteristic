<?php
declare(strict_types=1);

namespace App\Collections;

use App\dto\CharOutDto;
use App\dto\ValueOutDto;
use App\Exceptions\ValueObjectConstraint;

final class ValueOutCollection extends \ArrayObject
{
    public function append($value): void
    {
        if (!$value instanceof ValueOutDto) {
            throw new ValueObjectConstraint("Instance of ValueOutDto expected");
        }
        parent::append($value);
    }
}