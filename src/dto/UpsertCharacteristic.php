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
     *      type="string",
     *      description="Тип данных в которых будет храниться характеристика",
     *      enum={"string", "fk", "int", "float", "boolean", "array"},
     *      example="string"
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
     * UpsertCharacteristic constructor.
     * @param I18nCharVO $i18n
     * @param SearchPropertyVO $searchProperties
     * @param EnumVO $fieldType
     * @param AliasVO $attrName
     */
    public function __construct(I18nCharVO $i18n, SearchPropertyVO $searchProperties, EnumVO $fieldType, AliasVO $attrName)
    {
        $this->i18n = $i18n;
        $this->searchProperties = $searchProperties;
        $this->fieldType = $fieldType;
        $this->attrName = $attrName;
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


}