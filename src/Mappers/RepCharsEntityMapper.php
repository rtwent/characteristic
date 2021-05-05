<?php
declare(strict_types=1);

namespace App\Mappers;

use App\Collections\ValueOutCollection;
use App\dto\CharOutDto;
use App\dto\CharOutRawDto;
use App\dto\CharWithValuesOutDto;
use App\dto\RepCharValuesOutDto;
use App\dto\ValueOutDto;
use App\Entity\Characteristics;
use App\Entity\RepresentationValues;
use App\Entity\Values;
use App\Services\Locale\CurrentLanguage;

final class RepCharsEntityMapper
{
    private RepresentationValues $entity;

    /**
     * @param RepresentationValues $entity
     */
    public function __construct(RepresentationValues $entity)
    {
        $this->entity = $entity;
    }

    public function toDto(): RepCharValuesOutDto
    {
        $valuesCollection = $this->entity->getCharacteristicValues();
        $valueOutCollection = new ValueOutCollection();
        foreach ($valuesCollection as $repValue) {
            /** @var Values $repValue */
            $valueOutCollection->append((new ValuesEntityMapper($repValue))->toDto());
        }

        return new RepCharValuesOutDto(
            $this->entity->getId(),
            $this->entity->getRepresentation()->getId(),
            new CharWithValuesOutDto(
                (new CharacteristicEntityMapper($this->entity->getCharacteristic()))->toDto(),
                $valueOutCollection
            ),
            $this->entity->getSettings()
        );
    }

}