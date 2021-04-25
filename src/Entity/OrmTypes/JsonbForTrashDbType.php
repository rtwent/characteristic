<?php
declare(strict_types=1);


namespace App\Entity\OrmTypes;

use App\Entity\ValueObjects\I18nValuesFieldsVO;
use App\Entity\ValueObjects\I18nValuesVO;
use App\Exceptions\ValueObjectConstraint;
use Doctrine\DBAL\Platforms\AbstractPlatform;

final class JsonbForTrashDbType extends JsonbToArrayType
{
    const TYPE_NAME = 'JsonbForTrashDbType';
    private const DEFAULT_VALUE = '{}';

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        try {
            $dbValue = json_encode($value, JSON_UNESCAPED_UNICODE);
            if (empty($value)) {
                $dbValue = self::DEFAULT_VALUE;
            }
        } catch (\Throwable $e) {
            $dbValue = self::DEFAULT_VALUE;
        }

        return $dbValue;
    }

}