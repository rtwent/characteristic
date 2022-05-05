<?php
declare(strict_types=1);

namespace App\Services\ValidationServices\Characteristics;

use App\Enum\CharsTypeEnum;
use App\Enum\LangsEnum;
use App\Services\ValidationServices\AbstractServiceValidator;
use App\Services\ValidationServices\CustomValidators\MeasureUnitExists;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @package App\Services\ValidationServices
 */
class CharacteristicCreate extends AbstractServiceValidator
{
    /**
     * Came from \App\EventSubscriber\ValidateRequest::$validators
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $entityManager;

    /**
     * StoreStepsValidation constructor.
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        parent::__construct();
    }

    /**
     * @return Assert\Collection
     */
    public function rule(): Assert\Collection
    {
        $langCollection = [];
        foreach (LangsEnum::values() as $lang) {
            $langCollection[$lang] = new Assert\Required();
        }

        return new Assert\Collection([
            'attrName' => new Assert\Required([
                new Assert\Type('string'),
                new Assert\Regex('/^[ -a-zA-Zа-яА-я0-9]+$/')
            ]),
            'i18n' => new Assert\Required([
                new Assert\Type('array'),
                new Assert\Collection($langCollection)
            ]),
            'fieldType' => new Assert\Required([
                new Assert\Type('string'),
                new Assert\Choice([
                    'choices' => CharsTypeEnum::values(),
                    'message' => sprintf("The value you selected is not a valid choice. (%s) are only accepted", implode(", ", CharsTypeEnum::values())),
                ])
            ]),
            'property' => new Assert\NotBlank(),
            'measureUnit' => new Assert\Sequentially([
                new MeasureUnitExists(['entityManager' => $this->entityManager]),
            ])
        ]);
    }
}