<?php
declare(strict_types=1);


namespace App\Entity\OrmTypes;

use App\Exceptions\ValueObjectConstraint;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use App\Entity\ValueObjects\I18nCharVO;

final class CharSearchPropertyDbType extends JsonbToArrayType
{
    const TYPE_NAME = 'CharSearchPropertyType';

    /**
     * @param mixed $value
     * @param AbstractPlatform $platform
     * @return I18nCharVO|mixed
     * @throws ValueObjectConstraint
     */
    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        return new I18nCharVO(json_decode($value, true));
    }
}