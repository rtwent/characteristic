<?php
declare(strict_types=1);


namespace App\dto;


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
     *      type="string",
     *      enum={"string", "fk", "int", "float", "boolean", "array"}
     * )
     */
    private string $type;
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
     *      ref=@Model(type=App\Entity\ValueObjects\SearchPropertyVO::class)
     * )
     */
    private array $searchProps;

    /**
     * CharOutDto constructor.
     * @param Uuid $id
     * @param string $alias
     * @param string $type
     * @param array $searchProps
     */
    public function __construct(Uuid $id, string $alias, string $type, array $searchProps, array $i18n)
    {
        $this->id = $id;
        $this->alias = $alias;
        $this->type = $type;
        $this->searchProps = $searchProps;
        $this->i18n = $i18n;
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
     * @return string
     */
    public function getType(): string
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
     * @return array
     */
    public function getSearchProps(): array
    {
        return $this->searchProps;
    }


}