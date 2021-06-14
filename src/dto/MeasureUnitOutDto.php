<?php
declare(strict_types=1);


namespace App\dto;

use OpenApi\Annotations as OA;

final class MeasureUnitOutDto
{
    /**
     * @OA\Property(
     *      description="Внутренний айди",
     *      type="integer"
     * )
     */
    private int $id;
    /**
     * @OA\Property(
     *      description="Название характеристики в системе СИ (роль псевдонима)",
     *      type="string"
     * )
     */
    private string $siName;
    /**
     * @OA\Property(
     *      description="Перевод хаарктеристики на язык локали",
     *      type="string"
     * )
     */
    private string $label;

    /**
     * MeasureUnitOutDto constructor.
     * @param string $siName
     * @param string $label
     */
    public function __construct(int $id, string $siName, string $label)
    {
        $this->id = $id;
        $this->siName = $siName;
        $this->label = $label;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }


    /**
     * @return string
     */
    public function getSiName(): string
    {
        return $this->siName;
    }

    /**
     * @return string
     */
    public function getLabel(): string
    {
        return $this->label;
    }


}