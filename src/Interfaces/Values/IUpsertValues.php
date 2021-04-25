<?php

namespace App\Interfaces\Values;

use App\dto\UpsertValue;
use App\dto\ValueOutDto;
use App\Entity\ValueObjects\UuidVO;

interface IUpsertValues
{
    public function create(UpsertValue $valuesDto): ValueOutDto;

    public function update(UpsertValue $valuesDto, UuidVO $uuid): ValueOutDto;

    public function delete(UuidVO $uuidVO): void;
}