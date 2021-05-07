<?php
declare(strict_types=1);


namespace App\dto;


use App\Collections\RepCharValuesCollection;
use App\Entity\ValueObjects\RepCharValueSettingsVO;
use App\Entity\ValueObjects\UuidVO;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Annotations as OA;

final class UpsertCharValuesDto
{
    /**
     * @OA\Property(
     *      description="Id представительства",
     *      type="string",
     *      property="rep_uuid"
     * )
     */
    private UuidVO $representation;
    /**
     * @OA\Property(
     *      description="Id характеристики",
     *      type="string",
     *      property="char_uuid"
     * )
     */
    private UuidVO $characteristic;
    /**
     * @OA\Property(
     *      description="Настройки значений характеристики",
     *      property="char_values",
     *      type="array",
     *      @OA\Items(
     *          ref=@Model(type=App\Entity\ValueObjects\RepCharValuesVO::class)
     *      )
     * )
     */
    private RepCharValuesCollection $repCharValues;
    /**
     * @OA\Property(
     *      description="Настройки отображения характеристик",
     *      ref=@Model(type=App\Entity\ValueObjects\RepCharValueSettingsVO::class)
     * )
     */
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