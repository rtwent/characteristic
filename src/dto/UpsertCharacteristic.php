<?php
declare(strict_types=1);

namespace App\dto;

use App\Entity\ValueObjects\AliasVO;
use App\Entity\ValueObjects\EnumVO;
use App\Entity\ValueObjects\I18nCharVO;
use App\Entity\ValueObjects\SearchPropertyVO;

final class UpsertCharacteristic
{
    private I18nCharVO $i18n;
    private SearchPropertyVO $searchProperties;
    private EnumVO $fieldType;
    private AliasVO $attrName;

    /**
     * UpsertCharacteristic constructor.
     * @param I18nCharVO $i18n
     * @param SearchPropertyVO $searchProperties
     * @param EnumVO $fieldType
     * @param AliasVO $attrName
     */
    public function __construct(I18nCharVO $i18n, SearchPropertyVO $searchProperties, EnumVO $fieldType, AliasVO $attrName)
    {
        $this->i18n = $i18n;
        $this->searchProperties = $searchProperties;
        $this->fieldType = $fieldType;
        $this->attrName = $attrName;
    }

    /**
     * @return I18nCharVO
     */
    public function getI18n(): I18nCharVO
    {
        return $this->i18n;
    }

    /**
     * @return SearchPropertyVO
     */
    public function getSearchProperties(): SearchPropertyVO
    {
        return $this->searchProperties;
    }

    /**
     * @return EnumVO
     */
    public function getFieldType(): EnumVO
    {
        return $this->fieldType;
    }

    /**
     * @return AliasVO
     */
    public function getAttrName(): AliasVO
    {
        return $this->attrName;
    }


}