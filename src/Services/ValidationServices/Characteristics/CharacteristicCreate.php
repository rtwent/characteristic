<?php
declare(strict_types=1);

namespace App\Services\ValidationServices\Characteristics;

use App\Enum\CharsTypeEnum;
use App\Enum\InputTypeEnum;
use App\Enum\LangsEnum;
use App\Services\ValidationServices\AbstractServiceValidator;
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
            'attribute' => new Assert\Required([
                new Assert\Type('string'),
                new Assert\Regex('/^[-a-z0-9]+$/')
            ]),
            'i18n' => new Assert\Required([
                new Assert\Type('array'),
                new Assert\Collection($langCollection)
            ]),
            'type' => new Assert\Required([
                new Assert\Type('string'),
                new Assert\Choice(CharsTypeEnum::values())
            ]),
            'property' => new Assert\NotBlank()
        ]);
    }
}