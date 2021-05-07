<?php
declare(strict_types=1);

namespace App\dto;

use App\Entity\ValueObjects\I18nValuesVO;
use App\Entity\ValueObjects\RealtyTypesVO;
use App\Entity\ValueObjects\UuidVO;
use OpenApi\Annotations as OA;
use Nelmio\ApiDocBundle\Annotation\Model;

final class UpsertValue
{
    /**
     * @OA\Property(
     *      description="Uuid значение характеристики",
     *      type="string",
     *      property="fk_char"
     * )
     */
    private UuidVO $fkChar;
    /**
     * @OA\Property(
     *     description="Языковые данные характеристики",
     *     type="object",
     *     property="i18n",
     *     @OA\Property(
     *          property="ru",
     *          type="string",
     *          ref=@Model(type=App\Entity\ValueObjects\I18nValuesFieldsVO::class)
     *      ),
     *     @OA\Property(
     *          property="ua",
     *          type="string",
     *          ref=@Model(type=App\Entity\ValueObjects\I18nValuesFieldsVO::class)
     *      )
     * )
     */
    private I18nValuesVO $i18n;
    /**
     * @OA\Property(
     *      description="Ключ значения (deprecated)",
     *      type="integer"
     * )
     */
    private int $key;
    /**
     * @OA\Property(
     *      description="Дефолтная сортировка",
     *      type="integer",
     *      property="default_sort"
     * )
     */
    private int $defaultSort;
    /**
     * @OA\Property(
     *      type="array",
     *      property="only_type",
     *      @OA\Items(
     *          ref="#/components/schemas/RealtyTypeEnum"
     *      )
     * )
     */
    private RealtyTypesVO $onlyType;

    /**
     * UpsertValue constructor.
     * @param UuidVO $fkChar
     * @param I18nValuesVO $i18n
     * @param int $key
     * @param int $defaultSort
     * @param RealtyTypesVO $onlyType
     */
    public function __construct(UuidVO $fkChar, I18nValuesVO $i18n, int $key, int $defaultSort, RealtyTypesVO $onlyType)
    {
        $this->fkChar = $fkChar;
        $this->i18n = $i18n;
        $this->key = $key;
        $this->defaultSort = $defaultSort;
        $this->onlyType = $onlyType;
    }

    /**
     * @return UuidVO
     */
    public function getFkChar(): UuidVO
    {
        return $this->fkChar;
    }

    /**
     * @return I18nValuesVO
     */
    public function getI18n(): I18nValuesVO
    {
        return $this->i18n;
    }

    /**
     * @return int
     */
    public function getKey(): int
    {
        return $this->key;
    }

    /**
     * @return int
     */
    public function getDefaultSort(): int
    {
        return $this->defaultSort;
    }

    /**
     * @return RealtyTypesVO
     */
    public function getOnlyType(): RealtyTypesVO
    {
        return $this->onlyType;
    }


}