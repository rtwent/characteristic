<?php
declare(strict_types=1);


namespace App\Entity\OrmTypes;


use App\Enum\CharsTypeEnum;
use Elao\Enum\Bridge\Doctrine\DBAL\Types\AbstractEnumType;

final class CharTypeDbType extends AbstractEnumType
{
    public const NAME = 'CharType';

    protected function getEnumClass(): string
    {
        return CharsTypeEnum::class;
    }

    public function getName(): string
    {
        return static::NAME;
    }
}