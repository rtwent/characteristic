<?php
declare(strict_types=1);


namespace App\dto;


use App\Entity\ValueObjects\RepCharValueSettingsVO;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Serializer\Annotation\Groups;

final class RepCharValuesOutDto
{
    /**
     * @Groups({"repCharValues"})
     */
    private int $id;
    /**
     * @Groups({"repCharValues"})
     */
    private Uuid $representationUuid;
    /**
     * @Groups({"repCharValues"})
     */
    private CharWithValuesOutDto $characteristic;

    /**
     * @Groups({"repCharValues"})
     */
    private RepCharValueSettingsVO $characteristicSettings;

    /**
     * RepCharValuesOutDto constructor.
     * @param int $id
     * @param Uuid $representationUuid
     * @param CharWithValuesOutDto $characteristic
     * @param RepCharValueSettingsVO $characteristicSettings
     */
    public function __construct(
        int $id,
        Uuid $representationUuid,
        CharWithValuesOutDto $characteristic,
        RepCharValueSettingsVO $characteristicSettings
    )
    {
        $this->id = $id;
        $this->representationUuid = $representationUuid;
        $this->characteristic = $characteristic;
        $this->characteristicSettings = $characteristicSettings;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return Uuid
     */
    public function getRepresentationUuid(): Uuid
    {
        return $this->representationUuid;
    }

    /**
     * @return CharWithValuesOutDto
     */
    public function getCharacteristic(): CharWithValuesOutDto
    {
        return $this->characteristic;
    }

    /**
     * @return RepCharValueSettingsVO
     */
    public function getCharacteristicSettings(): RepCharValueSettingsVO
    {
        return $this->characteristicSettings;
    }


}