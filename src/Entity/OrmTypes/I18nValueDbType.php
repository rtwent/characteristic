<?php
declare(strict_types=1);


namespace App\Entity\OrmTypes;

use App\Entity\ValueObjects\I18nValuesFieldsVO;
use App\Entity\ValueObjects\I18nValuesVO;
use App\Exceptions\ValueObjectConstraint;
use Doctrine\DBAL\Platforms\AbstractPlatform;

final class I18nValueDbType extends JsonbToArrayType
{
    const TYPE_NAME = 'I18nCharValueDbType';

    /**
     * @param mixed $value
     * @param AbstractPlatform $platform
     * @return I18nValuesVO|mixed
     * @throws ValueObjectConstraint
     */
    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        $decoded = json_decode($value, true);
        $constructorArg = [];
        foreach ($decoded as $lang => $charField) {
            $constructorArg[$lang] = new I18nValuesFieldsVO($charField['label'] ?? '-');
        }

        return new I18nValuesVO($constructorArg);
    }

}