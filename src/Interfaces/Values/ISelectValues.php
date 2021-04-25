<?php


namespace App\Interfaces\Values;


use App\dto\ValueOutDto;
use App\Entity\ValueObjects\UuidVO;

interface ISelectValues
{
    public function singleChar(UuidVO $uuidVO): ValueOutDto;
}