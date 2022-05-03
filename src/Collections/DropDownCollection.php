<?php
declare(strict_types=1);

namespace App\Collections;

use App\dto\DropDownDto;
use App\Exceptions\ValueObjectConstraint;

final class DropDownCollection extends \ArrayObject
{
    public function append($value): void
    {
        if (!$value instanceof DropDownDto) {
            throw new ValueObjectConstraint("Instance of DropDownDto expected");
        }
        parent::append($value);
    }
}