<?php
declare(strict_types=1);


namespace App\Entity\ValueObjects;


use App\Collections\DropDownCollection;
use App\dto\DropDownDto;
use OpenApi\Annotations as OA;
use Nelmio\ApiDocBundle\Annotation\Model;

final class SearchPropertyDropDownVO
{
    /**
     * @OA\Property(
     *     type="integer",
     *     description="Дефолтный порядок сортировки"
     * )
     */
    private int $sort;
    /**
     * @OA\Property(
     *     ref=@Model(type=App\dto\DropDownDto::class)
     * )
     */
    private DropDownDto $input;
    /**
     * @OA\Property(
     *     description="Типы недвижимости для которых данная характеристика актуальна",
     *     type="array",
     **     @OA\Items(
     *          ref=@Model(type=App\dto\DropDownDto::class)
     *     )
     * )
     */
    private DropDownCollection $types;
    /**
     * @OA\Property(
     *     description="Типы категорий поиска для которых данная характеристика актуальна",
     *     type="array",
     *     @OA\Items(
     *          ref=@Model(type=App\dto\DropDownDto::class)
     *     )
     * )
     */
    private DropDownCollection $categories;
    /**
     * @OA\Property(
     *     type="boolean",
     *     description="Является ли аттрибут секретным"
     * )
     */
    private bool $isSecret;

    public function __construct(
        int                $sort,
        DropDownDto        $input,
        DropDownCollection $types,
        DropDownCollection $categories,
        bool               $isSecret
    )
    {
        $this->sort = $sort;
        $this->input = $input;
        $this->types = $types;
        $this->categories = $categories;
        $this->isSecret = $isSecret;
    }

    /**
     * @return int
     */
    public function getSort(): int
    {
        return $this->sort;
    }

    /**
     * @return DropDownDto
     */
    public function getInput(): DropDownDto
    {
        return $this->input;
    }

    /**
     * @return DropDownCollection
     */
    public function getTypes(): DropDownCollection
    {
        return $this->types;
    }

    /**
     * @return DropDownCollection
     */
    public function getCategories(): DropDownCollection
    {
        return $this->categories;
    }

    /**
     * @return bool
     */
    public function isSecret(): bool
    {
        return $this->isSecret;
    }

}