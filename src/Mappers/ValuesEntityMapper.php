<?php
declare(strict_types=1);

namespace App\Mappers;

use App\Collections\DropDownCollection;
use App\dto\CharOutDto;
use App\dto\CharOutRawDto;
use App\dto\DropDownDto;
use App\dto\ValueOutDto;
use App\dto\ValueOutRawDto;
use App\Entity\Characteristics;
use App\Entity\Values;
use App\Exceptions\ValueObjectConstraint;
use App\Services\Locale\CurrentLanguage;
use Symfony\Contracts\Translation\TranslatorInterface;

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

    /**
     * @throws ValueObjectConstraint
     */
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

    /**
     * @throws ValueObjectConstraint
     */
    public function toRawDto(TranslatorInterface $translator): ValueOutRawDto
    {
        $onlyTypesCollection = new DropDownCollection();
        $types = $this->entity->getOnlyType()->toArray();
        foreach ($types as $type) {
            $onlyTypesCollection->append(new DropDownDto($type, $translator->trans($type, [], 'enums')));
        }

        return new ValueOutRawDto(
            $this->entity->getId(),
            $this->entity->getKey(),
            $this->entity->getDefaultSort(),
            $this->entity->getI18n(),
            $onlyTypesCollection
        );
    }


}