<?php
declare(strict_types=1);


namespace App\dto;


use Symfony\Component\Uid\Uuid;
use Symfony\Component\Serializer\Annotation\Groups;
use OpenApi\Annotations as OA;
use Nelmio\ApiDocBundle\Annotation\Model;
use Symfony\Component\Serializer\Annotation\SerializedName;

class CharOutDto
{
    /**
     * @OA\Property(
     *      description="Uuid характеристики",
     *      type="string"
     * )
     * @Groups({"repCharValues", "char:item:read"})
     */
    protected Uuid $id;
    /**
     * @OA\Property(
     *      description="Уникальный псевдоним характеристики",
     *      type="string"
     * )
     * @Groups({"repCharValues", "char:item:read"})
     */
    protected string $alias;
    /**
     * @OA\Property(
     *      description="Тип характеристики. Используется для вычисления типа переменной, в которой себе хранит характеристика",
     *     ref="#/components/schemas/DataTypeEnum"
     * )
     * @Groups({"repCharValues", "char:item:read"})
     */
    protected string $type;
    /**
     * @OA\Property(
     *      description="Полное название характеристики на текущей локали",
     *      type="string",
     * )
     * @SerializedName("name")
     * @Groups({"repCharValues", "char:item:read"})
     */
    protected string $label;
    /**
     * @OA\Property(
     *      description="Короткое название характеристики на текущей локали",
     *      type="string"
     * )
     * @Groups({"repCharValues", "char:item:read"})
     */
    protected string $short;

    /**
     * @OA\Property(
     *      description="Единица измерения характеристики",
     *      type="string"
     * )
     * @Groups({"repCharValues", "char:item:read"})
     */
    protected ?string $measurement;

    /**
     * @OA\Property(
     *     ref=@Model(type=App\Entity\ValueObjects\SearchPropertyVO::class)
     * )
     * @Groups({"repCharValues", "char:item:read"})
     */
    protected array $searchProps;

    /**
     * CharOutDto constructor.
     * @param Uuid $id
     * @param string $alias
     * @param string $type
     * @param string $label
     * @param string $short
     * @param array $searchProps
     * @param string|null $measurement
     */
    public function __construct(Uuid $id, string $alias, string $type, string $label, string $short, array $searchProps, ?string $measurement)
    {
        $this->id = $id;
        $this->alias = $alias;
        $this->type = $type;
        $this->label = $label;
        $this->short = $short;
        $this->searchProps = $searchProps;
        $this->measurement = $measurement;
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
     * @return string
     */
    public function getLabel(): string
    {
        return $this->label;
    }

    /**
     * @return string
     */
    public function getShort(): string
    {
        return $this->short;
    }

    /**
     * @return array
     */
    public function getSearchProps(): array
    {
        return $this->searchProps;
    }

    /**
     * @return string|null
     */
    public function getMeasurement(): ?string
    {
        return $this->measurement;
    }


}