<?php
declare(strict_types=1);


namespace App\Entity\OrmTypes;

use App\Entity\ValueObjects\I18nValuesFieldsVO;
use App\Entity\ValueObjects\I18nValuesVO;
use App\Entity\ValueObjects\RealtyTypesVO;
use App\Enum\RealtyTypeEnum;
use App\Exceptions\ValueObjectConstraint;
use Doctrine\DBAL\Platforms\AbstractPlatform;

final class RealtyTypes extends JsonbToArrayType
{
    const TYPE_NAME = 'RealtyTypesDbType';

    /**
     * @param mixed $value
     * @param AbstractPlatform $platform
     * @return mixed
     * @throws ValueObjectConstraint
     */
    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        $decoded = parent::convertToPHPValue($value, $platform);

        foreach ($decoded as $realtyType) {
            if (!RealtyTypeEnum::accepts($realtyType)) {
                throw new ValueObjectConstraint(sprintf("Property %s not supported by RealtyTypeEnum", $realtyType));
            }
        }

        return new RealtyTypesVO($decoded);
    }

}