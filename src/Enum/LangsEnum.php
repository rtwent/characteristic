<?php
declare(strict_types=1);

namespace App\Enum;

use Elao\Enum\Enum;

/**
 * @see https://github.com/Elao/PhpEnums
 * @package App\Enum
 */
final class LangsEnum extends Enum
{
    public const LANG_RU = 'ru';
    public const LANG_UA = 'ua';

    public static function values(): array
    {
        return [
            self::LANG_RU,
            self::LANG_UA,
        ];
    }
}