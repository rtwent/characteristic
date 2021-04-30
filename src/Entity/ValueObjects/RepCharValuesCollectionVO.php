<?php
declare(strict_types=1);


namespace App\Entity\ValueObjects;


use App\Exceptions\ValueObjectConstraint;
use App\Interfaces\ToArray;
use JsonSerializable;

final class RepCharValuesCollectionVO implements ToArray, JsonSerializable
{
    const SORT_FIELD = 'sort';

    private array $charValues;

    /**
     * RepCharValuesCollectionVO constructor.
     * @param RepCharValuesVO[] $charValues
     * @throws ValueObjectConstraint
     */
    public function __construct(array $charValues)
    {
        $this->charValues = $this->setCharValues($charValues);
    }

    private function setCharValues(array $charValues): array
    {
        foreach ($charValues as $charValue) {
            if (!$charValue instanceof RepCharValuesVO) {
                throw new ValueObjectConstraint(sprintf("Instance of RepCharValuesVO expected. Get %s", gettype($charValue)));
            }
        }

        return $charValues;
    }

    /**
     * @return array
     */
    public function getCharValues(): array
    {
        return $this->charValues;
    }

    public function jsonSerialize()
    {
        return json_encode($this->toArray(), \JSON_UNESCAPED_UNICODE);
    }

    public function toArray(): array
    {
        $result = [];

        foreach ($this->charValues as $charValue) {
            /** @var $charValue RepCharValuesVO */
            $result[$charValue->getUuid()] = [self::SORT_FIELD => $charValue->getSort()];
        }

        return $result;
    }

}