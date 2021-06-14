<?php
declare(strict_types=1);

namespace App\Mappers;

use App\dto\CharOutDto;
use App\dto\CharOutRawDto;
use App\dto\MeasureUnitOutDto;
use App\dto\MeasureUnitRawOutDto;
use App\Entity\Characteristics;
use App\Entity\MeasureUnits;
use App\Exceptions\ValueObjectConstraint;
use App\Services\Locale\CurrentLanguage;

final class MeasureUnitEntityMapper
{
    private MeasureUnits $entity;

    /**
     * CharacteristicEntity constructor.
     * @param MeasureUnits $entity
     */
    public function __construct(MeasureUnits $entity)
    {
        $this->entity = $entity;
    }

    /**
     * @return MeasureUnitOutDto
     * @throws ValueObjectConstraint
     */
    public function toDto(): MeasureUnitOutDto
    {
        $lang = CurrentLanguage::getInstance()->currentLang();

        return new MeasureUnitOutDto(
            $this->entity->getId(),
            $this->entity->getSiName(),
            $this->entity->getI18n()->singleLanguage($lang)->getLabel(),
        );
    }

    public function toRawDto(): MeasureUnitRawOutDto
    {
        return new MeasureUnitRawOutDto(
            $this->entity->getId(),
            $this->entity->getSiName(),
            $this->entity->getI18n()->toArray()
        );
    }


}