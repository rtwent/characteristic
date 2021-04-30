<?php
declare(strict_types=1);


namespace App\Entity\ValueObjects;


final class RepCharValuesVO
{
    private string $uuid;
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