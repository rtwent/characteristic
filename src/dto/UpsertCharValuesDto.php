<?php
declare(strict_types=1);


namespace App\dto;


use App\Collections\RepCharValuesCollection;
use App\Entity\ValueObjects\UuidVO;

final class UpsertCharValuesDto
{
    private UuidVO $representation;
    private UuidVO $characteristic;
    private RepCharValuesCollection $repCharValues;

    /**
     * UpsertCharValuesDto constructor.
     * @param UuidVO $representation
     * @param UuidVO $characteristic
     * @param RepCharValuesCollection $repCharValues
     */
    public function __construct(UuidVO $representation, UuidVO $characteristic, RepCharValuesCollection $repCharValues)
    {
        $this->representation = $representation;
        $this->characteristic = $characteristic;
        $this->repCharValues = $repCharValues;
    }

    /**
     * @return UuidVO
     */
    public function getRepresentation(): UuidVO
    {
        return $this->representation;
    }

    /**
     * @return UuidVO
     */
    public function getCharacteristic(): UuidVO
    {
        return $this->characteristic;
    }

    /**
     * @return RepCharValuesCollection
     */
    public function getRepCharValues(): RepCharValuesCollection
    {
        return $this->repCharValues;
    }




}