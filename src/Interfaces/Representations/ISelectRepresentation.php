<?php

namespace App\Interfaces\Representations;

use App\Collections\CharWithValuesOutCollection;
use App\Entity\ValueObjects\RealtyTypeVO;
use App\Entity\ValueObjects\UuidVO;

interface ISelectRepresentation
{
    public function allChars(UuidVO $uuidVO): CharWithValuesOutCollection;

    public function allCharsByRealtyType(UuidVO $uuidVO, RealtyTypeVO $realtyTypeVO): CharWithValuesOutCollection;
}