<?php
declare(strict_types=1);


namespace App\dto;


use App\Collections\RepCharValuesCollection;
use App\Entity\ValueObjects\RepCharValueSettingsVO;
use App\Entity\ValueObjects\UuidVO;

final class UpsertCharValuesDto
{
    private UuidVO $representation;
    private UuidVO $characteristic;
    private RepCharValuesCollection $repCharValues;
    private RepCharValueSettingsVO $settings;

    /**
     * UpsertCharValuesDto constructor.
     * @param UuidVO $representation
     * @param UuidVO $characteristic
     * @param RepCharValuesCollection $repCharValues
     * @param RepCharValueSettingsVO $settings
     */
    public function __construct(
        UuidVO $representation,
        UuidVO $characteristic,
        RepCharValuesCollection $repCharValues,
        RepCharValueSettingsVO $settings
    )
    {
        $this->representation = $representation;
        $this->characteristic = $characteristic;
        $this->repCharValues = $repCharValues;
        $this->settings = $settings;
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

    /**
     * @return RepCharValueSettingsVO
     */
    public function getSettings(): RepCharValueSettingsVO
    {
        return $this->settings;
    }


}