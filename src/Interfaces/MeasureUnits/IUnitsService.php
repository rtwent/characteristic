<?php


namespace App\Interfaces\MeasureUnits;


use App\Collections\MeasureUnitOutCollection;
use App\dto\MeasureUnitOutDto;
use App\dto\MeasureUnitRawOutDto;
use App\dto\UpsertMeasureUnit;

interface IUnitsService
{
    /**
     * List of all measurement units
     * @return MeasureUnitOutCollection
     */
    public function collection(): MeasureUnitOutCollection;

    /**
     * Единичная характеристика без локали
     * @param int $id
     * @return MeasureUnitRawOutDto
     */
    public function raw(int $id): MeasureUnitRawOutDto;

    /**
     * Creating
     * @param UpsertMeasureUnit $dto
     * @return MeasureUnitOutDto
     */
    public function create(UpsertMeasureUnit $dto): MeasureUnitOutDto;
}