<?php
declare(strict_types=1);

namespace App\dto;

use App\Entity\ValueObjects\I18nMeasureUnitsVO;
use OpenApi\Annotations as OA;
use Nelmio\ApiDocBundle\Annotation\Model;

final class UpsertMeasureUnit
{
    /**
     * @OA\Property(
     *      description="Си название характеристики",
     *      type="string"
     * )
     */
    private string $siName;
    /**
     * @OA\Property(
     *     description="Языковые данные характеристики",
     *     type="object",
     *     property="i18n",
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
    private I18nMeasureUnitsVO $i18n;

    /**
     * UpsertMeasureUnit constructor.
     * @param string $siName
     * @param I18nMeasureUnitsVO $i18n
     */
    public function __construct(string $siName, I18nMeasureUnitsVO $i18n)
    {
        $this->siName = $siName;
        $this->i18n = $i18n;
    }

    /**
     * @return string
     */
    public function getSiName(): string
    {
        return $this->siName;
    }

    /**
     * @return I18nMeasureUnitsVO
     */
    public function getI18n(): I18nMeasureUnitsVO
    {
        return $this->i18n;
    }


}