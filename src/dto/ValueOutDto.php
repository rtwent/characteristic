<?php
declare(strict_types=1);


namespace App\dto;


use App\Entity\ValueObjects\RepCharValuePropertiesVO;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Serializer\Annotation\Groups;
use OpenApi\Annotations as OA;
use Nelmio\ApiDocBundle\Annotation\Model;

class ValueOutDto
{
    /**
     * @OA\Property(
     *      description="Uuid значение характеристики",
     *      type="string"
     * )
     * @Groups({"repCharValues"})
     */
    private Uuid $id;
    /**
     * @OA\Property(
     *      description="Полное название значения характеристики на текущей локали",
     *      type="string"
     * )
     * @Groups({"repCharValues"})
     */
    private string $label;

    /**
     * @OA\Property(
     *      description="Ключ значения характеристики (deprecated)",
     *      type="integer"
     * )
     * @deprecated field must be removed
     * @var int
     */
    private int $key;

    /**
     * @OA\Property(
     *      description="Дефолтная сортировка значение характеристики",
     *      type="integer"
     * )
     */
    private int  $defaultSort;
    /**
     * @OA\Property(
     *      description="Типы недвижимости для которых актуально значение характеристики",
     *      type="array",
     *      @OA\Items(
     *          ref="#/components/schemas/RealtyTypeEnum"
     *      )
     * )
     * @Groups({"repCharValues"})
     */
    private array $onlyType;

    /**
     * @OA\Property(
     *     ref=@Model(type=App\dto\CharOutDto::class)
     * )
     */
    private CharOutDto $char;

    /**
     * @Groups({"repCharValues"})
     */
    private ?RepCharValuePropertiesVO $specific = null;

    /**
     * ValueOutDto constructor.
     * @param Uuid $id
     * @param string $label
     * @param int $key
     * @param int $defaultSort
     * @param array $onlyType
     * @param CharOutDto $char
     * @param RepCharValuePropertiesVO|null $specific
     */
    public function __construct(
        Uuid $id,
        string $label,
        int $key,
        int $defaultSort,
        array $onlyType,
        CharOutDto $char,
        ?RepCharValuePropertiesVO $specific
    )
    {
        $this->id = $id;
        $this->label = $label;
        $this->key = $key;
        $this->defaultSort = $defaultSort;
        $this->onlyType = $onlyType;
        $this->char = $char;
        $this->specific = $specific;
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
    public function getLabel(): string
    {
        return $this->label;
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
     * @return array
     */
    public function getOnlyType(): array
    {
        return $this->onlyType;
    }

    /**
     * @return CharOutDto
     */
    public function getChar(): CharOutDto
    {
        return $this->char;
    }

    /**
     * @return RepCharValuePropertiesVO|null
     */
    public function getSpecific(): ?RepCharValuePropertiesVO
    {
        return $this->specific;
    }


}