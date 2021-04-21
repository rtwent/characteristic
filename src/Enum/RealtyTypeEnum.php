<?php
declare(strict_types=1);

namespace App\Enum;

use Elao\Enum\Enum;

/**
 * @see https://github.com/Elao/PhpEnums
 * @package App\Enum
 */
final class RealtyTypeEnum extends Enum
{
    public const APARTMENT = 'apartment';
    public const HOUSE = 'house';
    public const COMMERCIAL = 'commercial';
    public const APARTMENT_COMPLEX = 'apartment_complex';

    public static function values(): array
    {
        return [
            self::APARTMENT,
            self::HOUSE,
            self::COMMERCIAL,
            self::APARTMENT_COMPLEX,
        ];
    }
}