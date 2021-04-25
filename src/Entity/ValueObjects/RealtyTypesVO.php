<?php
declare(strict_types=1);


namespace App\Entity\ValueObjects;


use App\Enum\RealtyTypeEnum;
use App\Exceptions\ValueObjectConstraint;
use App\Interfaces\ToArray;

final class RealtyTypesVO implements \JsonSerializable, ToArray
{
    private array $realtyTypes;

    /**
     * @param array $realtyTypes
     * @throws ValueObjectConstraint
     */
    public function __construct(array $realtyTypes)
    {
        $this->realtyTypes = $this->setRealtyTypes($realtyTypes);
    }

    public function jsonSerialize()
    {
        return json_encode($this->realtyTypes, \JSON_UNESCAPED_UNICODE);
    }

    public function toArray(): array
    {
        return json_decode($this->jsonSerialize(), true);
    }

    /**
     * @param array $realtyTypes
     * @return array
     * @throws ValueObjectConstraint
     */
    private function setRealtyTypes(array $realtyTypes): array
    {
        $realtyTypesFromEnum = RealtyTypeEnum::values();
        $diff = array_diff($realtyTypes, $realtyTypesFromEnum);
        if (count($diff) > 0) {
            throw new ValueObjectConstraint(sprintf("Incorrect keys %s for realty types", implode(', ', $diff)));
        }

        return $realtyTypes;
    }


}