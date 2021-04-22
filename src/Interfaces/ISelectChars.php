<?php


namespace App\Interfaces;


use App\Collections\CharOutCollection;
use App\dto\CharFilter;
use App\dto\CharOutDto;
use App\dto\CharOutRawDto;
use App\Entity\ValueObjects\UuidVO;

interface ISelectChars
{
    /**
     * Единичная характеристика с переводом
     * @param UuidVO $uuidVO
     * @return CharOutDto
     */
    public function singleChar(UuidVO $uuidVO): CharOutDto;

    /**
     * Единичная характеристика со всеми переводами
     * @param UuidVO $uuidVO
     * @return CharOutRawDto
     */
    public function rawChar(UuidVO $uuidVO): CharOutRawDto;

    /**
     * Коллекция по поиску
     * @param CharFilter $dto
     * @return CharOutCollection
     */
    public function collection(CharFilter $dto): CharOutCollection;
}