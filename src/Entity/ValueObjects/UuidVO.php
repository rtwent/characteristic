<?php
declare(strict_types=1);


namespace App\Entity\ValueObjects;


use App\Exceptions\ValueObjectConstraint;

final class UuidVO extends BaseValueObject
{
    private string $uuid;

    /**
     * @param string $uuid
     * @throws ValueObjectConstraint
     */
    public function __construct(string $uuid)
    {
        $this->uuid = $this->setUuid($uuid);
    }

    public function getValue(): string
    {
        return $this->uuid;
    }

    private function setUuid(string $uuid): string
    {
        $value = $this->filterEmptyParam($uuid);
        if (preg_match('/^[0-9a-f]{8}-[0-9a-f]{4}-[4][0-9a-f]{3}-[89ab][0-9a-f]{3}-[0-9a-f]{12}$/i', $value)) {
            return $value;
        }

        throw new ValueObjectConstraint(sprintf("Value %s is not valid for Alias", $value));
    }

}