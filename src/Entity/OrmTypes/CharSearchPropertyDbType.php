<?php
declare(strict_types=1);


namespace App\Entity\OrmTypes;

use App\Collections\RealtyCategoriesCollection;
use App\Collections\RealtyTypesCollection;
use App\Entity\ValueObjects\SearchPropertyVO;
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
        $decoded = json_decode($value, true)['search'] ?? [];
        $sort = $decoded['sort'] ?? 0;
        $input = $decoded['input'] ?? null;
        $isSecret = $decoded['is_secret'] ?? false;

        $realtyTypes = $decoded['types'] ?? [];
        $realtyTypeCollection = new RealtyTypesCollection();
        foreach ($realtyTypes as $realtyType) {
            $realtyTypeCollection->append($realtyType);
        }

        $categories = $decoded['categories'] ?? [];
        $categoriesCollection = new RealtyCategoriesCollection();
        foreach ($categories as $category) {
            $categoriesCollection->append($category);
        }

        return new SearchPropertyVO(
            $sort, $input, $realtyTypeCollection, $categoriesCollection, $isSecret
        );
    }
}