<?php
declare(strict_types=1);


namespace App\Entity\OrmTypes;

use App\Entity\ValueObjects\I18nCharFieldsVO;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use App\Entity\ValueObjects\I18nCharVO;

final class I18nCharDbType extends JsonbToArrayType
{
    const TYPE_NAME = 'I18nCharDbType';

    /**
     * @param mixed $value
     * @param AbstractPlatform $platform
     * @return I18nCharVO|mixed
     */
    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        $decoded = json_decode($value, true);
        $constructorArg = [];
        foreach ($decoded as $lang => $charField) {
            $constructorArg[$lang] = new I18nCharFieldsVO($charField['label'] ?? '-', $charField['short'] ?? '-');
        }

        return new I18NCharVO($constructorArg);
    }

}