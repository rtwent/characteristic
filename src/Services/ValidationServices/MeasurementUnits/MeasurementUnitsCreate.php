<?php
declare(strict_types=1);

namespace App\Services\ValidationServices\MeasurementUnits;

use App\Enum\CharsTypeEnum;
use App\Enum\LangsEnum;
use App\Services\ValidationServices\AbstractServiceValidator;
use App\Services\ValidationServices\CustomValidators\MeasureUnitExists;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @package App\Services\ValidationServices
 */
class MeasurementUnitsCreate extends AbstractServiceValidator
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
            //$langCollection[$lang] = new Assert\Required();
            $langCollection[$lang] = new Assert\Collection([
                'label' => new Assert\Type('string'),
            ]);
        }

        return new Assert\Collection([
            'siName' => new Assert\Required([
                new Assert\Type('string'),
                new Assert\Regex('/^[a-z]{1,5}$/', 'Value must match /^[a-z]{1,5}$/')
            ]),
            'i18n' => new Assert\Required([
                new Assert\Type('array'),
                new Assert\Collection($langCollection)
            ]),
        ]);
    }
}