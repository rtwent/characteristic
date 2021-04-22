<?php
declare(strict_types=1);

namespace App\Collections;

use App\dto\CharOutDto;
use App\Exceptions\ValueObjectConstraint;

final class CharOutCollection extends \ArrayObject
{
    public function append($value): void
    {
        if (!$value instanceof CharOutDto) {
            throw new ValueObjectConstraint("Instance of CharOutDto expected");
        }
        parent::append($value);
    }
}