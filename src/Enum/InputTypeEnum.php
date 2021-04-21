<?php
declare(strict_types=1);

namespace App\Enum;

use Elao\Enum\Enum;

/**
 * @see https://github.com/Elao/PhpEnums
 * @package App\Enum
 */
final class InputTypeEnum extends Enum
{
    public const TEXT = 'text';
    public const SELECT = 'select';
    public const DATE_MIN_MAX = 'date-min-max';
    public const SELECT2 = 'select2';
    public const NUMBER_MIN_MAX = 'number-min-max';
    public const CHECKBOX = 'checkbox';

    public static function values(): array
    {
        return [
            self::TEXT,
            self::SELECT,
            self::DATE_MIN_MAX,
            self::SELECT2,
            self::NUMBER_MIN_MAX,
            self::CHECKBOX,
        ];
    }
}