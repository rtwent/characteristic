<?php
declare(strict_types=1);

namespace App\Collections;

use App\dto\CharOutDto;
use App\dto\CharWithValuesOutDto;
use App\Exceptions\ValueObjectConstraint;

final class CharWithValuesOutCollection extends \ArrayObject
{
    public function append($value): void
    {
        if (!$value instanceof CharWithValuesOutDto) {
            throw new ValueObjectConstraint("Instance of CharWithValuesOutDto expected");
        }
        parent::append($value);
    }
}