<?php
declare(strict_types=1);

namespace App\Services\ValidationServices\RepresentationValues;

use App\Entity\ValueObjects\RepCharValuesCollectionVO;
use App\Enum\CharsTypeEnum;
use App\Enum\InputTypeEnum;
use App\Enum\LangsEnum;
use App\Enum\RealtyTypeEnum;
use App\Services\ValidationServices\AbstractServiceValidator;
use App\Services\ValidationServices\CustomValidators\CharacteristicExists;
use App\Services\ValidationServices\CustomValidators\RepresentationExists;
use App\Services\ValidationServices\CustomValidators\ValueExists;
use App\Services\ValidationServices\CustomValidators\ValueExistsInCharacteristic;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Validator\Constraints as Assert;

class RepresentationValuesCreate extends AbstractServiceValidator
{
    /**
     * Came from \App\EventSubscriber\ValidateRequest::$validators
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $entityManager;
    /**
     * @var RequestStack
     */
    private RequestStack $request;

    /**
     * StoreStepsValidation constructor.
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager, RequestStack $request)
    {
        $this->entityManager = $entityManager;
        $this->request = $request;
        parent::__construct();
    }

    /**
     * @return Assert\Collection
     */
    public function rule(): Assert\Collection
    {
        try {
            $characteristicValue = json_decode($this->request->getCurrentRequest()->getContent(), true);
            $charUuid = $characteristicValue['char_uuid'] ?? '';
        } catch (\Throwable $e) {
            $charUuid = '';
        }

        return new Assert\Collection([
            'rep_uuid' => new Assert\Required([
                // otherwise all validation rules will take part at the same time, generating db error at RepresentationExists()
                new Assert\Sequentially([
                    new Assert\Type('string'),
                    new Assert\NotBlank(),
                    new Assert\Regex('/[0-9a-f]{8}-[0-9a-f]{4}-[4][0-9a-f]{3}-[89ab][0-9a-f]{3}-[0-9a-f]{12}/'),
                    new RepresentationExists(['entityManager' => $this->entityManager]),
                ])
            ]),
            'char_uuid' => new Assert\Required([
                new Assert\Sequentially([
                    new Assert\Type('string'),
                    new Assert\NotBlank(),
                    new CharacteristicExists(['entityManager' => $this->entityManager]),
                ])
            ]),
            'settings' => new Assert\Required([
                new Assert\Type('array'),
                new Assert\Collection([
                    'rowId' => new Assert\Type('integer'),
                    'rowOrder' => new Assert\Type('integer')
                ])
            ]),
            'char_values' => new Assert\Required([
                new Assert\Sequentially([
                    new Assert\Type('array'),
                    new Assert\All([
                        new Assert\Collection([
                            RepCharValuesCollectionVO::SORT_FIELD => [
                                new Assert\Required(),
                                new Assert\Type('integer')
                            ],
                            'value_uuid' => [
                                new Assert\Type('string'),
                                new Assert\Regex('/[0-9a-f]{8}-[0-9a-f]{4}-[4][0-9a-f]{3}-[89ab][0-9a-f]{3}-[0-9a-f]{12}/'),
                                new ValueExists(['entityManager' => $this->entityManager]),
                                new ValueExistsInCharacteristic(['entityManager' => $this->entityManager, 'args' => $charUuid])
                            ]
                        ])
                    ])
                ])
            ]),
        ]);
    }
}