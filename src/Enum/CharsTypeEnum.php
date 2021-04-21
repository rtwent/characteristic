<?php
declare(strict_types=1);

namespace App\Enum;

use Elao\Enum\Enum;

/**
 * @see https://github.com/Elao/PhpEnums
 * @package App\Enum
 */
final class CharsTypeEnum extends Enum
{
    public const TYPE_JSON = 'json';
    public const TYPE_ARRAY = 'array';
    public const TYPE_BOOLEAN = 'boolean';
    public const TYPE_FLOAT = 'float';
    public const TYPE_INT = 'int';
    public const TYPE_FK = 'fk';
    public const TYPE_STRING = 'string';

    public static function values(): array
    {
        return [
            self::TYPE_JSON,
            self::TYPE_ARRAY,
            self::TYPE_BOOLEAN,
            self::TYPE_FLOAT,
            self::TYPE_INT,
            self::TYPE_FK,
            self::TYPE_STRING,
        ];
    }
}