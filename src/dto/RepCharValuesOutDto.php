<?php
declare(strict_types=1);


namespace App\dto;


use App\Entity\ValueObjects\RepCharValueSettingsVO;
use Nelmio\ApiDocBundle\Annotation\Model;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Serializer\Annotation\Groups;
use OpenApi\Annotations as OA;

final class RepCharValuesOutDto
{
    /**
     * @OA\Property(
     *      description="id характеристики",
     *      type="integer"
     * )
     * @Groups({"repCharValues"})
     */
    private int $id;
    /**
     * @OA\Property(
     *      description="Uuid представительства",
     *      type="string"
     * )
     * @Groups({"repCharValues"})
     */
    private Uuid $representationUuid;
    /**
     * @OA\Property(
     *      description="Характеристика со значениями",
     *      ref=@Model(type=App\dto\CharWithValuesOutDto::class, groups={"repCharValues"})
     * )
     * @Groups({"repCharValues"})
     */
    private CharWithValuesOutDto $characteristic;

    /**
     * @OA\Property(
     *      description="Настройки отображения характеристики для представительства",
     *      ref=@Model(type=App\Entity\ValueObjects\RepCharValueSettingsVO::class, groups={"repCharValues"})
     * )
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