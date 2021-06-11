<?php
declare(strict_types=1);

namespace App\dto;

use App\Entity\ValueObjects\AliasVO;
use App\Entity\ValueObjects\EnumVO;
use App\Entity\ValueObjects\I18nCharVO;
use App\Entity\ValueObjects\SearchPropertyVO;
use OpenApi\Annotations as OA;
use Nelmio\ApiDocBundle\Annotation\Model;

final class UpsertCharacteristic
{
    /**
     * @OA\Property(
     *     description="Языковые данные характеристики",
     *     type="object",
     *     @OA\Property(
     *          property="ru",
     *          type="string",
     *          ref=@Model(type=App\Entity\ValueObjects\I18nCharFieldsVO::class)
     *      ),
     *     @OA\Property(
     *          property="ua",
     *          type="string",
     *          ref=@Model(type=App\Entity\ValueObjects\I18nCharFieldsVO::class)
     *      )
     * )
     */
    private I18nCharVO $i18n;
    /**
     * @OA\Property(
     *     property="property",
     *     type="object",
     *     @OA\Property(
     *          property="search",
     *          ref=@Model(type=App\Entity\ValueObjects\SearchPropertyVO::class)
     *      )
     *
     * )
     */
    private SearchPropertyVO $searchProperties;
    /**
     * @OA\Property(
     *      description="Тип данных в которых будет храниться характеристика",
     *      ref="#/components/schemas/DataTypeEnum"
     * )
     */
    private EnumVO $fieldType;
    /**
     * @OA\Property(
     *      type="string",
     *      example="some_alias",
     *      description="Regexp /^[-a-z0-9_]+$/"
     * )
     */
    private AliasVO $attrName;

    /**
     * @OA\Property(
     *      type="string",
     *      description="ID единицы измерения (пустая строка при отсутствии)"
     * )
     */
    private ?int $measureUnit;

    /**
     * UpsertCharacteristic constructor.
     * @param I18nCharVO $i18n
     * @param SearchPropertyVO $searchProperties
     * @param EnumVO $fieldType
     * @param AliasVO $attrName
     * @param int|null $measureUnit
     */
    public function __construct(I18nCharVO $i18n, SearchPropertyVO $searchProperties, EnumVO $fieldType, AliasVO $attrName, ?int $measureUnit)
    {
        $this->i18n = $i18n;
        $this->searchProperties = $searchProperties;
        $this->fieldType = $fieldType;
        $this->attrName = $attrName;
        $this->measureUnit = $measureUnit;
    }

    /**
     * @return I18nCharVO
     */
    public function getI18n(): I18nCharVO
    {
        return $this->i18n;
    }

    /**
     * @return SearchPropertyVO
     */
    public function getSearchProperties(): SearchPropertyVO
    {
        return $this->searchProperties;
    }

    /**
     * @return EnumVO
     */
    public function getFieldType(): EnumVO
    {
        return $this->fieldType;
    }

    /**
     * @return AliasVO
     */
    public function getAttrName(): AliasVO
    {
        return $this->attrName;
    }

    /**
     * @return int|null
     */
    public function getMeasureUnit(): ?int
    {
        return $this->measureUnit;
    }


}