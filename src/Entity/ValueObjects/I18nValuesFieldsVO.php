<?php
declare(strict_types=1);

namespace App\Entity\ValueObjects;


use App\Exceptions\ValueObjectConstraint;
use App\Interfaces\ToArray;

final class I18nValuesFieldsVO extends BaseValueObject implements \JsonSerializable, ToArray
{
    /**
     * Название характеристики
     * @var string
     */
    private string $label;

    /**
     *
     * @param string $label
     * @throws ValueObjectConstraint
     */
    public function __construct(string $label)
    {
        $this->label = $this->filterEmptyParam($label, 'Label');
    }

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }

    public function toArray(): array
    {
        return ['label' => $this->label];
    }

    /**
     * @return string
     */
    public function getLabel(): string
    {
        return $this->label;
    }

}