<?php
declare(strict_types=1);


namespace App\dto;


use OpenApi\Annotations as OA;

class DropDownDto
{
    /**
     * @OA\Property(
     *      description="Uuid характеристики",
     *      type="string"
     * )
     */
    private string $id;
    /**
     * @OA\Property(
     *      description="Название выпадающего списка",
     *      type="string"
     * )
     */
    private string $name;

    /**
     * @param string $id
     * @param string $name
     */
    public function __construct(string $id, string $name)
    {
        $this->id = $id;
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }


}