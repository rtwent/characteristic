<?php
declare(strict_types=1);


namespace App\Entity\ValueObjects;


use App\Collections\RealtyCategoriesCollection;
use App\Collections\RealtyTypesCollection;
use App\Enum\InputTypeEnum;
use App\Exceptions\ValueObjectConstraint;

final class SearchPropertyVO extends BaseValueObject
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
        string $input,
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

    private function setInput(string $value): string
    {
        if (!InputTypeEnum::accepts($value)) {
            throw new ValueObjectConstraint(sprintf("Value %s does not exist in InputTypeEnum", $value));
        }

        return $value;
    }


}