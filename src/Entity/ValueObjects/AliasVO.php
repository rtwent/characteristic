<?php
declare(strict_types=1);


namespace App\Entity\ValueObjects;


use App\Exceptions\ValueObjectConstraint;

final class AliasVO extends BaseValueObject
{
    private string $alias;

    /**
     * AliasVO constructor.
     * @param string $alias
     * @throws ValueObjectConstraint
     */
    public function __construct(string $alias)
    {
        $this->alias = $this->setAlias($alias);
    }

    public function getValue(): string
    {
        return $this->alias;
    }

    private function setAlias(string $alias): string
    {
        $value = $this->filterEmptyParam($alias);
        if (preg_match('/^[-a-z0-9]+$/', $value)) {
            return $value;
        }

        throw new ValueObjectConstraint(sprintf("Value %s is not valid for Alias", $value));
    }

}