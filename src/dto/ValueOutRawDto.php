<?php
declare(strict_types=1);

namespace App\dto;

use App\Collections\DropDownCollection;
use App\Entity\ValueObjects\I18nValuesVO;
use App\Entity\ValueObjects\RepCharValuePropertiesVO;
use Symfony\Component\Uid\Uuid;
use OpenApi\Annotations as OA;
use Nelmio\ApiDocBundle\Annotation\Model;
use Symfony\Component\Serializer\Annotation\Groups;

final class ValueOutRawDto
{
    /**
     * @OA\Property(
     *      description="Uuid значение характеристики",
     *      type="string"
     * )
     */
    private Uuid $id;

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
    private int $defaultSort;

    /**
     * @OA\Property(
     *     description="Языковые данные ловаря",
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
     *
     * @var I18nValuesVO
     */
    private I18nValuesVO $i18n;

    /**
     * @OA\Property(
     *     description="Дропдаун с типами недвижимости",
     *     type="array",
     *     @OA\Items(ref=@Model(type=App\dto\DropDownDto::class))
     * )
     *
     * @var DropDownCollection
     */
    private DropDownCollection $onlyTypeDropDown;

    public function __construct(
        Uuid                      $id,
        int                       $key,
        int                       $defaultSort,
        I18nValuesVO              $i18n,
        DropDownCollection        $onlyTypeDropDown
    )
    {
        $this->id = $id;
        $this->key = $key;
        $this->defaultSort = $defaultSort;
        $this->i18n = $i18n;
        $this->onlyTypeDropDown = $onlyTypeDropDown;
    }

    /**
     * @return Uuid
     */
    public function getId(): Uuid
    {
        return $this->id;
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
    public function getI18n(): array
    {
        return $this->i18n->toArray();
    }

    /**
     * @return DropDownCollection
     */
    public function getOnlyTypeDropDown(): DropDownCollection
    {
        return $this->onlyTypeDropDown;
    }


}