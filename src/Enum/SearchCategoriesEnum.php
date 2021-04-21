<?php
declare(strict_types=1);

namespace App\Enum;

use Elao\Enum\Enum;

/**
 * @see https://github.com/Elao/PhpEnums
 * @package App\Enum
 */
final class SearchCategoriesEnum extends Enum
{
    public const SECRET = 'secret';
    public const MAIN = 'main';
    public const SERVICE = 'service';
    public const ADDITIONAL = 'additional';
    public const RENT = 'rent';
    public const SERVICE_BUYER = 'servicebuyer';

    public static function values(): array
    {
        return [
            self::SECRET,
            self::MAIN,
            self::SERVICE,
            self::ADDITIONAL,
            self::RENT,
            self::SERVICE_BUYER,
        ];
    }
}