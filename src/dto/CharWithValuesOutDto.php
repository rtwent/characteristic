<?php
declare(strict_types=1);


namespace App\dto;


use App\Collections\ValueOutCollection;
use Symfony\Component\Serializer\Annotation\Groups;

final class CharWithValuesOutDto
{
    /**
     * @Groups({"repCharValues"})
     */
    private CharOutDto $charOutDto;
    /**
     * @Groups({"repCharValues"})
     */
    private ValueOutCollection $values;

    /**
     * CharWithValuesOutDto constructor.
     * @param CharOutDto $charOutDto
     * @param ValueOutCollection $values
     */
    public function __construct(CharOutDto $charOutDto, ValueOutCollection $values)
    {
        $this->charOutDto = $charOutDto;
        $this->values = $values;
    }

    /**
     * @return CharOutDto
     */
    public function getCharOutDto(): CharOutDto
    {
        return $this->charOutDto;
    }

    /**
     * @return ValueOutCollection
     */
    public function getValues()
    {
        return $this->values;
    }


}