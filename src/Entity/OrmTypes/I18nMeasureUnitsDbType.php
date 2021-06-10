<?php
declare(strict_types=1);


namespace App\Entity\OrmTypes;

use App\Entity\ValueObjects\I18nMeasureUnitsFieldsVO;
use App\Entity\ValueObjects\I18nMeasureUnitsVO;
use App\Exceptions\ValueObjectConstraint;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use App\Entity\ValueObjects\I18nCharVO;

final class I18nMeasureUnitsDbType extends JsonbToArrayType
{
    const TYPE_NAME = 'I18nMeasureUnitsDbType';

    /**
     * @param mixed $value
     * @param AbstractPlatform $platform
     * @return I18nCharVO|mixed
     * @throws ValueObjectConstraint
     */
    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        $decoded = json_decode($value, true);
        $constructorArg = [];
        foreach ($decoded as $lang => $charField) {
            $constructorArg[$lang] = new I18nMeasureUnitsFieldsVO($charField['label'] ?? '-');
        }

        return new I18nMeasureUnitsVO($constructorArg);
    }

}