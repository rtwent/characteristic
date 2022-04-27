<?php
declare(strict_types=1);

namespace App\Mappers;

use App\dto\CharOutDto;
use App\dto\CharOutRawDto;
use App\Entity\Characteristics;
use App\Exceptions\ValueObjectConstraint;
use App\Services\Locale\CurrentLanguage;

final class CharacteristicEntityMapper
{
    private Characteristics $entity;

    /**
     * CharacteristicEntity constructor.
     * @param Characteristics $entity
     */
    public function __construct(Characteristics $entity)
    {
        $this->entity = $entity;
    }

    /**
     * @throws ValueObjectConstraint
     */
    public function toDto(): CharOutDto
    {
        $lang = CurrentLanguage::getInstance()->currentLang();

        return new CharOutDto(
            $this->entity->getId(),
            $this->entity->getAlias(),
            $this->entity->getType()->getValue(),
            $this->entity->getI18n()->singleLanguage($lang)->getLabel(),
            $this->entity->getI18n()->singleLanguage($lang)->getShort(),
            $this->entity->getProperty()->toArray(),
            $this->entity->getMeasureUnit()?->getI18n()?->singleLanguage($lang)?->getLabel()
        );
    }

    public function toRawDto(): CharOutRawDto
    {
        return new CharOutRawDto(
            $this->entity->getId(),
            $this->entity->getAlias(),
            $this->entity->getType()->getValue(),
            $this->entity->getProperty()->toArray(),
            $this->entity->getI18n()->toArray()
        );
    }


}