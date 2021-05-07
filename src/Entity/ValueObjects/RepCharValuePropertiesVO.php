<?php
declare(strict_types=1);


namespace App\Entity\ValueObjects;


use App\Interfaces\ToArray;
use Symfony\Component\Serializer\Annotation\Groups;
use OpenApi\Annotations as OA;

final class RepCharValuePropertiesVO implements ToArray
{
    /**
     * @OA\Property(
     *      description="Сортировка значение характеристики",
     *      type="integer"
     * )
     * @Groups({"repCharValues"})
     */
    private int $sort;

    /**
     * RepCharValueSettingsVO constructor.
     * @param int $sort
     */
    public function __construct(int $sort)
    {
        $this->sort = $sort;
    }

    public function toArray(): array
    {
        return [
            'rowId' => $this->rowId,
            'rowOrder' => $this->rowOrder,
            'types' => $this->realtyTypes->getArrayCopy()
        ];
    }

    /**
     * @return int
     */
    public function getSort(): int
    {
        return $this->sort;
    }


}