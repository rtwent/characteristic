<?php
declare(strict_types=1);


namespace App\Entity\ValueObjects;
use OpenApi\Annotations as OA;


final class RepCharValuesVO
{
    /**
     * @OA\Property(
     *      description="Id значения характеристики",
     *      type="string",
     *      property="value_uuid"
     * )
     */
    private string $uuid;
    /**
     * @OA\Property(
     *      description="Порядок сортировки значения характеристики",
     *      type="integer",
     * )
     */
    private int $sort;

    /**
     * RepCharValuesVO constructor.
     * @param string $uuid
     * @param int $sort
     */
    public function __construct(string $uuid, int $sort)
    {
        $this->uuid = $uuid;
        $this->sort = $sort;
    }

    /**
     * @return string
     */
    public function getUuid(): string
    {
        return $this->uuid;
    }

    /**
     * @return int
     */
    public function getSort(): int
    {
        return $this->sort;
    }


}