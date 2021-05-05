<?php
declare(strict_types=1);


namespace App\Entity\ValueObjects;


use App\Collections\RealtyTypesCollection;
use App\Interfaces\ToArray;
use Symfony\Component\Serializer\Annotation\Groups;

final class RepCharValueSettingsVO implements ToArray
{
    /**
     * @Groups({"repCharValues"})
     */
    private int $rowId;
    /**
     * @Groups({"repCharValues"})
     */
    private int $rowOrder;
    /**
     * @Groups({"repCharValues"})
     */
    private RealtyTypesCollection $realtyTypes;

    /**
     * RepCharValueSettingsVO constructor.
     * @param int $rowId
     * @param int $rowOrder
     * @param RealtyTypesCollection $realtyTypes
     */
    public function __construct(int $rowId, int $rowOrder, RealtyTypesCollection $realtyTypes)
    {
        $this->rowId = $rowId;
        $this->rowOrder = $rowOrder;
        $this->realtyTypes = $realtyTypes;
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
     * @deprecated affects on object normalization
     * @return false|string
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

    /**
     * @return RealtyTypesCollection
     */
    public function getRealtyTypes(): RealtyTypesCollection
    {
        return $this->realtyTypes;
    }


}