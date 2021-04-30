<?php
declare(strict_types=1);


namespace App\Entity\ValueObjects;


use App\Exceptions\ValueObjectConstraint;

final class RealtyTypeVO extends RealtyTypesVO
{
    private string $realtyType;

    /**
     * @param string $realtyType
     * @throws ValueObjectConstraint
     */
    public function __construct(string $realtyType)
    {
        parent::__construct([$realtyType]);
        $this->realtyType = $this->setRealtyTypes([$realtyType])[0];
    }

    public function getValue(): string
    {
        return $this->realtyType;
    }

}