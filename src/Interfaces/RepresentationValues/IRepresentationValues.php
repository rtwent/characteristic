<?php


namespace App\Interfaces\RepresentationValues;


use App\dto\RepCharValuesOutDto;
use App\dto\UpsertCharValuesDto;

interface IRepresentationValues
{
    public function create(UpsertCharValuesDto $dto): RepCharValuesOutDto;

    public function update(int $id, UpsertCharValuesDto $dto): RepCharValuesOutDto;

    public function delete(int $id): void;
}