<?php
declare(strict_types=1);

namespace App\Mappers;

use App\Collections\DropDownCollection;
use App\dto\CharOutDto;
use App\dto\CharOutRawDto;
use App\dto\DropDownDto;
use App\Entity\Characteristics;
use App\Entity\ValueObjects\SearchPropertyDropDownVO;
use App\Exceptions\ValueObjectConstraint;
use App\Services\Locale\CurrentLanguage;
use Symfony\Contracts\Translation\TranslatorInterface;

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

    /**
     * @param TranslatorInterface $translator
     * @return CharOutRawDto
     * @throws ValueObjectConstraint
     */
    public function toRawDto(TranslatorInterface $translator): CharOutRawDto
    {
        $charTypesCollection = new DropDownCollection();
        foreach ($this->entity->getProperty()->getTypes() as $type) {
            $charTypesCollection->append(new DropDownDto($type, $translator->trans($type, [], 'enums')));
        }

        $categoriesCollection = new DropDownCollection();
        foreach ($this->entity->getProperty()->getCategories() as $category) {
            $categoriesCollection->append(new DropDownDto($category, $translator->trans($category, [], 'enums')));
        }

        $charProperty = new SearchPropertyDropDownVO(
            $this->entity->getProperty()->getSort(),
            new DropDownDto($this->entity->getProperty()->getInput() ?? "", $translator->trans($this->entity->getProperty()->getInput() ?? "", [], 'enums')),
            $charTypesCollection,
            $categoriesCollection,
            $this->entity->getProperty()->isSecret()
        );

        $measureUnit = null;
        if(!\is_null($this->entity->getMeasureUnit()?->getId())) {
            $measureUnit = new DropDownDto(strval($this->entity->getMeasureUnit()->getId()), $this->entity->getMeasureUnit()->getSiName());
        }

        return new CharOutRawDto(
            $this->entity->getId(),
            $this->entity->getAlias(),
            new DropDownDto(
                $this->entity->getType()->getValue(),
                $translator->trans($this->entity->getType()->getValue(), [], 'enums')
            ),
            $charProperty,
            $this->entity->getI18n()->toArray(),
            $measureUnit
        );
    }


}