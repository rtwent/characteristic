<?php
declare(strict_types=1);


namespace App\dto;


use App\Entity\ValueObjects\UuidVO;
use App\Enum\RealtyTypeEnum;
use App\Enum\SearchCategoriesEnum;

final class ValuesBySearchCategories
{
    private UuidVO $representationUuid;
    private SearchCategoriesEnum $searchCategory;
    private ?RealtyTypeEnum $realtyType;

    /**
     * ValuesBySearchCategories constructor.
     * @param UuidVO $representationUuid
     * @param SearchCategoriesEnum $searchCategory
     * @param RealtyTypeEnum|null $realtyType
     */
    public function __construct(UuidVO $representationUuid, SearchCategoriesEnum $searchCategory, ?RealtyTypeEnum $realtyType)
    {
        $this->representationUuid = $representationUuid;
        $this->searchCategory = $searchCategory;
        $this->realtyType = $realtyType;
    }

    /**
     * @return UuidVO
     */
    public function getRepresentationUuid(): UuidVO
    {
        return $this->representationUuid;
    }

    /**
     * @return SearchCategoriesEnum
     */
    public function getSearchCategory(): SearchCategoriesEnum
    {
        return $this->searchCategory;
    }

    /**
     * @return RealtyTypeEnum|null
     */
    public function getRealtyType(): ?RealtyTypeEnum
    {
        return $this->realtyType;
    }


}