<?php
declare(strict_types=1);


namespace App\dto;

use OpenApi\Annotations as OA;
use Nelmio\ApiDocBundle\Annotation\Model;

final class MeasureUnitRawOutDto
{
    /**
     * @OA\Property(
     *      description="Внутренний айди",
     *      type="integer"
     * )
     */
    private int $id;
    /**
     * @OA\Property(
     *      description="Название характеристики в системе СИ (роль псевдонима)",
     *      type="string"
     * )
     */
    private string $siName;

    /**
     * @OA\Property(
     *     description="Языковые данные единицы измерения",
     *     type="object",
     *     @OA\Property(
     *          property="ru",
     *          type="string",
     *          ref=@Model(type=App\Entity\ValueObjects\I18nMeasureUnitsFieldsVO::class)
     *      ),
     *     @OA\Property(
     *          property="ua",
     *          type="string",
     *          ref=@Model(type=App\Entity\ValueObjects\I18nMeasureUnitsFieldsVO::class)
     *      )
     * )
     */
    private array $i18n;

    /**
     * MeasureUnitRawOutDto constructor.
     * @param int $id
     * @param string $siName
     * @param array $i18n
     */
    public function __construct(int $id, string $siName, array $i18n)
    {
        $this->id = $id;
        $this->siName = $siName;
        $this->i18n = $i18n;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getSiName(): string
    {
        return $this->siName;
    }

    /**
     * @return array
     */
    public function getI18n(): array
    {
        return $this->i18n;
    }


}