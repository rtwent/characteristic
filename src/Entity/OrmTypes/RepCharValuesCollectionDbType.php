<?php
declare(strict_types=1);


namespace App\Entity\OrmTypes;

use App\Entity\ValueObjects\I18nCharFieldsVO;
use App\Entity\ValueObjects\RepCharValuesCollectionVO;
use App\Entity\ValueObjects\RepCharValuesVO;
use App\Exceptions\InvalidArgument;
use App\Exceptions\OrmType;
use App\Exceptions\ValueObjectConstraint;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use App\Entity\ValueObjects\I18nCharVO;

final class RepCharValuesCollectionDbType extends JsonbToArrayType
{
    const TYPE_NAME = 'RepCharValuesCollectionDbType';

    /**
     * @param mixed $value
     * @param AbstractPlatform $platform
     * @return I18nCharVO|mixed
     * @throws ValueObjectConstraint
     */
    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        $decoded = json_decode($value, true);
        $repCharValues = [];
        foreach ($decoded as $charValueUuid => $valueSortRecord) {
            $repCharValues[] = new RepCharValuesVO($charValueUuid, $valueSortRecord['sort'] ?? 0);
        }

        return new RepCharValuesCollectionVO($repCharValues);

    }

}