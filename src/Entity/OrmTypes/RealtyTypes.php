<?php
declare(strict_types=1);


namespace App\Entity\OrmTypes;

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
        return ['TEST'];
//        $decoded = json_decode($value, true);
//        $constructorArg = [];
//        foreach ($decoded as $lang => $charField) {
//            $constructorArg[$lang] = new I18nValuesFieldsVO($charField['label'] ?? '-');
//        }
//
//        return new I18nValuesVO($constructorArg);
    }

}