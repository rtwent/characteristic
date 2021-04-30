<?php
declare(strict_types=1);

namespace App\Collections;

use App\dto\CharOutDto;
use App\dto\ValueOutDto;
use App\Entity\ValueObjects\RepCharValuesVO;
use App\Exceptions\ValueObjectConstraint;

final class RepCharValuesCollection extends \ArrayObject
{
    public function append($value): void
    {
        if (!$value instanceof RepCharValuesVO) {
            throw new ValueObjectConstraint("Instance of RepCharValuesVO expected");
        }
        parent::append($value);
    }
}