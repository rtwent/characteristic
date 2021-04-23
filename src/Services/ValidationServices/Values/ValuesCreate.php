<?php
declare(strict_types=1);

namespace App\Services\ValidationServices\Values;

use App\Enum\CharsTypeEnum;
use App\Enum\InputTypeEnum;
use App\Enum\LangsEnum;
use App\Enum\RealtyTypeEnum;
use App\Services\ValidationServices\AbstractServiceValidator;
use App\Services\ValidationServices\CustomValidators\CharacteristicExists;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @package App\Services\ValidationServices
 */
class ValuesCreate extends AbstractServiceValidator
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
            'i18n' => new Assert\Required([
                new Assert\Type('array'),
                new Assert\Collection($langCollection)
            ]),
            'key' => new Assert\Required([
                new Assert\NotBlank(),
                new Assert\Positive(),
            ]),
            'default_sort' => new Assert\Required([
                new Assert\NotBlank(),
                new Assert\Positive(),
            ]),
            'only_type' => new Assert\Required([
                new Assert\Type('array'),
                new Assert\All([
                    new Assert\Type('string'),
                    new Assert\Choice(RealtyTypeEnum::values())
                ])
            ]),
            'fk_char' => new Assert\Required([
                new CharacteristicExists(['entityManager' => $this->entityManager]),
            ]),
        ]);
    }
}