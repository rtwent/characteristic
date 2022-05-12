<?php
declare(strict_types=1);


namespace App\Entity\ValueObjects;


use App\Collections\RealtyTypesCollection;
use App\Interfaces\ToArray;
use Symfony\Component\Serializer\Annotation\Groups;
use OpenApi\Annotations as OA;
use Nelmio\ApiDocBundle\Annotation\Model;

final class RepCharValueSettingsVO implements ToArray
{
    /**
     * @OA\Property(
     *      description="Ряд для отображения характеристики",
     *      type="integer"
     * )
     * @Groups({"repCharValues"})
     */
    private int $rowId;
    /**
     * @OA\Property(
     *      description="Позиция в ряду для отображения характеристики",
     *      type="integer"
     * )
     * @Groups({"repCharValues"})
     */
    private int $rowOrder;

    /**
     * RepCharValueSettingsVO constructor.
     * @param int $rowId
     * @param int $rowOrder
     */
    public function __construct(int $rowId, int $rowOrder)
    {
        $this->rowId = $rowId;
        $this->rowOrder = $rowOrder;
    }

    public function toArray(): array
    {
        return [
            'rowId' => $this->rowId,
            'rowOrder' => $this->rowOrder,
        ];
    }

    /**
     * @return false|string
     * @deprecated affects on object normalization
     */
//    public function jsonSerialize()
//    {
//        return json_encode($this->toArray(), \JSON_UNESCAPED_UNICODE);
//    }

    /**
     * @return int
     */
    public function getRowId(): int
    {
        return $this->rowId;
    }

    /**
     * @return int
     */
    public function getRowOrder(): int
    {
        return $this->rowOrder;
    }

}