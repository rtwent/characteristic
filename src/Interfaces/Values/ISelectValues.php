<?php


namespace App\Interfaces\Values;


use App\Collections\ValueOutCollection;
use App\dto\ValueOutDto;
use App\Entity\ValueObjects\UuidVO;

interface ISelectValues
{
    public function singleChar(UuidVO $uuidVO): ValueOutDto;

    public function getValuesByChar(UuidVO $charId): ValueOutCollection;
}