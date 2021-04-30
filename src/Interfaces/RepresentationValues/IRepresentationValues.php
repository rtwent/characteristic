<?php


namespace App\Interfaces\RepresentationValues;


use App\dto\RepCharValuesOutDto;
use App\dto\UpsertCharValuesDto;

interface IRepresentationValues
{
    public function create(UpsertCharValuesDto $dto): RepCharValuesOutDto;
}