<?php
declare(strict_types=1);


namespace App\Entity\ValueObjects;


use App\Exceptions\ValueObjectConstraint;

final class EnumVO
{
    private string $enumValue;
    private string $enumClass;

    /**
     * EnumVO constructor.
     * @param string $enumValue
     * @param $enumClass
     * @throws ValueObjectConstraint
     */
    public function __construct(string $enumValue, $enumClass)
    {
        $this->enumClass = $enumClass;
        $this->enumValue = $this->setEnumValue($enumValue, $enumClass);

    }

    /**
     * @return string
     */
    public function getEnumValue(): string
    {
        //$enumInstance = call_user_func_array([$this->enumClass, 'get'], [$this->enumValue]);
        return $this->enumValue;
    }


    private function setEnumValue(string $enumValue): string
    {
        if (!class_exists($this->enumClass)) {
            throw new ValueObjectConstraint(sprintf("Class %s does not exists", $this->enumClass));
        }

        if (!method_exists($this->enumClass, 'accepts')) {
            throw new ValueObjectConstraint(sprintf("Method accepts does not exist in class %s. Use Elao\Enum\Enum as parent", $this->enumClass));
        }

        $enumAccepts = call_user_func_array([$this->enumClass, 'accepts'], [$enumValue]);
        if (!$enumAccepts) {
            throw new ValueObjectConstraint(sprintf("Value %s is not in enum %s", $enumValue, $this->enumClass));
        }

        return $enumValue;

    }

}