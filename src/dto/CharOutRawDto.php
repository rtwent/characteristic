<?php
declare(strict_types=1);


namespace App\dto;


use App\Entity\ValueObjects\SearchPropertyDropDownVO;
use Symfony\Component\Uid\Uuid;
use OpenApi\Annotations as OA;
use Nelmio\ApiDocBundle\Annotation\Model;

final class CharOutRawDto
{
    /**
     * @OA\Property(
     *      description="Uuid характеристики",
     *      type="string"
     * )
     */
    private Uuid $id;
    /**
     * @OA\Property(
     *      description="Уникальный псевдоним характеристики",
     *      type="string"
     * )
     */
    private string $alias;
    /**
     * @OA\Property(
     *      description="Тип характеристики. Используется для вычисления типа переменной, в которой себе хранит характеристика",
     *      ref=@Model(type=App\dto\DropDownDto::class)
     * )
     */
    private DropDownDto $type;
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
    private array $i18n;
    /**
     * @OA\Property(
     *      ref=@Model(type=App\Entity\ValueObjects\SearchPropertyDropDownVO::class)
     * )
     */
    private SearchPropertyDropDownVO $searchProps;

    /**
     * @OA\Property(
     *     anyOf={
     *          @Model(type=App\dto\DropDownDto::class),
     *          @Model(type=null)
     *
     *     }
     * )
     */
    private ?DropDownDto $measureUnit;

    /**
     * CharOutDto constructor.
     * @param Uuid $id
     * @param string $alias
     * @param DropDownDto $type
     * @param SearchPropertyDropDownVO $searchProps
     * @param array $i18n
     */
    public function __construct(
        Uuid                     $id,
        string                   $alias,
        DropDownDto              $type,
        SearchPropertyDropDownVO $searchProps,
        array                    $i18n,
        ?DropDownDto             $measureUnit
    )
    {
        $this->id = $id;
        $this->alias = $alias;
        $this->type = $type;
        $this->searchProps = $searchProps;
        $this->i18n = $i18n;
        $this->measureUnit = $measureUnit;
    }

    /**
     * @return Uuid
     */
    public function getId(): Uuid
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getAlias(): string
    {
        return $this->alias;
    }

    /**
     * @return DropDownDto
     */
    public function getType(): DropDownDto
    {
        return $this->type;
    }

    /**
     * @return array
     */
    public function getI18n(): array
    {
        return $this->i18n;
    }

    /**
     * @return SearchPropertyDropDownVO
     */
    public function getSearchProps(): SearchPropertyDropDownVO
    {
        return $this->searchProps;
    }

    /**
     * @return DropDownDto|null
     */
    public function getMeasureUnit(): ?DropDownDto
    {
        return $this->measureUnit;
    }

}