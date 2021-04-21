<?php
declare(strict_types=1);


namespace App\Entity\OrmTypes;

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
        return '{}';
        //return new I18NCharVO(json_decode($value, true));
    }

}