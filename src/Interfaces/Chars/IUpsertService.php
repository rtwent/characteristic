<?php
declare(strict_types=1);


namespace App\Interfaces\Chars;


use App\dto\CharOutDto;
use App\dto\UpsertCharacteristic;
use App\Entity\ValueObjects\UuidVO;

interface IUpsertService
{
    public function create(UpsertCharacteristic $characteristic): CharOutDto;

    public function update(UpsertCharacteristic $characteristic, UuidVO $uuidVo): CharOutDto;

    public function delete(UuidVO $uuidVo): void;
}