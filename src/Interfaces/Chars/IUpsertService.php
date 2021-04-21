<?php
declare(strict_types=1);


namespace App\Interfaces\Chars;


use App\dto\UpsertCharacteristic;

interface IUpsertService
{
public function create(UpsertCharacteristic $characteristic);
}