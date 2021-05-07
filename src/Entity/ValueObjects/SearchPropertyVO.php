<?php
declare(strict_types=1);


namespace App\Entity\ValueObjects;


use App\Collections\RealtyCategoriesCollection;
use App\Collections\RealtyTypesCollection;
use App\Enum\InputTypeEnum;
use App\Exceptions\ValueObjectConstraint;
use App\Interfaces\ToArray;
use OpenApi\Annotations as OA;

final class SearchPropertyVO extends BaseValueObject implements ToArray
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
     *     type="string",
     *     description="Тип поля, который должен генерироваться на фронтенде"
     * )
     */
    private ?string $input;
    /**
     * @OA\Property(
     *     description="Типы недвижимости для которых данная характеристика актуальна",
     *     type="array",
     *     @OA\Items(
     *          type="string",
     *          enum={"apartment", "house", "commercial", "apartment_complex"}
     *     )
     * )
     */
    private RealtyTypesCollection $types;
    /**
     * @OA\Property(
     *     description="Типы категорий поиска для которых данная характеристика актуальна",
     *     type="array",
     *     @OA\Items(
     *          type="string",
     *          enum={"secret", "main", "service", "additional", "rent"}
     *     )
     * )
     */
    private RealtyCategoriesCollection $categories;
    /**
     * @OA\Property(
     *     type="boolean",
     *     description="Является ли аттрибут секретным"
     * )
     */
    private bool $isSecret;

    /**
     * SearchPropertyVO constructor.
     * @param int $sort
     * @param string $input
     * @param RealtyTypesCollection $types
     * @param RealtyCategoriesCollection $categories
     * @param bool $isSecret
     * @throws ValueObjectConstraint
     */
    public function __construct(
        int $sort,
        ?string $input,
        RealtyTypesCollection $types,
        RealtyCategoriesCollection $categories,
        bool $isSecret
    )
    {
        $this->sort = $sort;
        $this->input = $this->setInput($input);
        $this->types = $types;
        $this->categories = $categories;
        $this->isSecret = $isSecret;
    }

    public function toArray(): array
    {
        $returnArray['search'] = [];

        $attributes = ['sort', 'input'];
        foreach ($attributes as $attribute) {
            if (isset($this->$attribute)) {
                $returnArray['search'][$attribute] = $this->$attribute;
            }
        }

        if (isset($this->isSecret)) {
            $returnArray['search']['is_secret'] = $this->isSecret;
        }

        if (isset($this->types)) {
            $returnArray['search']['types'] = $this->types->getArrayCopy();
        }

        if (isset($this->categories)) {
            $returnArray['search']['categories'] = $this->categories->getArrayCopy();
        }

        return $returnArray;
    }

    private function setInput(?string $value): ?string
    {
        if (\is_null($value)) {
            return null;
        }

        if (!InputTypeEnum::accepts($value)) {
            throw new ValueObjectConstraint(sprintf("Value %s does not exist in InputTypeEnum", $value));
        }

        return $value;
    }

    /**
     * @return int
     */
    public function getSort(): int
    {
        return $this->sort;
    }

    /**
     * @return string|null
     */
    public function getInput(): ?string
    {
        return $this->input;
    }

    /**
     * @return RealtyTypesCollection
     */
    public function getTypes(): RealtyTypesCollection
    {
        return $this->types;
    }

    /**
     * @return RealtyCategoriesCollection
     */
    public function getCategories(): RealtyCategoriesCollection
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