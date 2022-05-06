<?php
declare(strict_types=1);


namespace App\dto;


use App\Collections\ValueOutCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use OpenApi\Annotations as OA;

final class CharWithValuesForRepresentationOutDto extends CharWithValuesOutDto
{
    /**
     * @OA\Property(
     *     type="integer",
     *     description="дентификатор привязки характеристики к представительству",
     * )
     * @Groups({"repCharValues"})
     */
    private int $id;

    public function __construct(CharOutDto $charOutDto, ValueOutCollection $values, int $id)
    {
        $this->id = $id;
        parent::__construct($charOutDto, $values);
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }


}