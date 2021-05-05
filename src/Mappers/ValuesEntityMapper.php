<?php
declare(strict_types=1);

namespace App\Mappers;

use App\dto\CharOutDto;
use App\dto\CharOutRawDto;
use App\dto\ValueOutDto;
use App\Entity\Characteristics;
use App\Entity\Values;
use App\Services\Locale\CurrentLanguage;

final class ValuesEntityMapper
{
    private Values $entity;

    /**
     * @param Values $entity
     */
    public function __construct(Values $entity)
    {
        $this->entity = $entity;
    }

    public function toDto(): ValueOutDto
    {
        $lang = CurrentLanguage::getInstance()->currentLang();

        return new ValueOutDto(
            $this->entity->getId(),
            $this->entity->getI18n()->singleLanguage($lang)->getLabel(),
            $this->entity->getKey(),
            $this->entity->getDefaultSort(),
            $this->entity->getOnlyType()->toArray(),
            (new CharacteristicEntityMapper($this->entity->getFkChar()))->toDto(),
            $this->entity->getRepresentationSpecific()
        );
    }

//    public function toRawDto(): CharOutRawDto
//    {
//        return new CharOutRawDto(
//            $this->entity->getId(),
//            $this->entity->getAlias(),
//            $this->entity->getType()->getValue(),
//            $this->entity->getProperty()->toArray(),
//            $this->entity->getI18n()->toArray()
//        );
//    }


}