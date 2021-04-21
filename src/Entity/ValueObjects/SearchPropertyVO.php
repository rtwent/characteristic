<?php
declare(strict_types=1);


namespace App\Entity\ValueObjects;


use App\Collections\RealtyCategoriesCollection;
use App\Collections\RealtyTypesCollection;
use App\Enum\InputTypeEnum;
use App\Exceptions\ValueObjectConstraint;
use App\Interfaces\ToArray;

final class SearchPropertyVO extends BaseValueObject implements ToArray
{
    private int $sort;
    private string $input;
    private RealtyTypesCollection $types;
    private RealtyCategoriesCollection $categories;
    private bool $isSecret;

    /**
     * SearchPropertyVO constructor.
     * @param int $sort
     * @param string $input
     * @param RealtyTypesCollection $types
     * @param RealtyCategoriesCollection $categories
     * @param bool $isSecret
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

        $attributes = ['sort', 'input', 'isSecret'];
        foreach ($attributes as $attribute) {
            if (isset($this->$attribute)) {
                $returnArray['search'][$attribute] = $this->$attribute;
            }
        }

        if (isset($this->types)) {
            $returnArray['search']['types'] = $this->types->getArrayCopy();
        }

        if (isset($this->categories)) {
            $returnArray['search']['categories'] = $this->categories->getArrayCopy();
        }

        return $returnArray;;
    }

    private function setInput(?string $value): string
    {
        if (\is_null($value)) {
            return $value;
        }

        if (!InputTypeEnum::accepts($value)) {
            throw new ValueObjectConstraint(sprintf("Value %s does not exist in InputTypeEnum", $value));
        }

        return $value;
    }


}