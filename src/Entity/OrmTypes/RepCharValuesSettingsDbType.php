<?php
declare(strict_types=1);


namespace App\Entity\OrmTypes;

use App\Collections\RealtyTypesCollection;
use App\Entity\ValueObjects\RepCharValueSettingsVO;
use App\Exceptions\ValueObjectConstraint;
use Doctrine\DBAL\Platforms\AbstractPlatform;

final class RepCharValuesSettingsDbType extends JsonbToArrayType
{
    const TYPE_NAME = 'RepCharValuesSettingsDbType';

    /**
     * @param mixed $value
     * @param AbstractPlatform $platform
     * @return RepCharValueSettingsVO
     */
    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        $decoded = json_decode($value, true);

        return new RepCharValueSettingsVO(
            $decoded['rowId'] ?? 0,
            $decoded['rowOrder'] ?? 0
        );

    }

}