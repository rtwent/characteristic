<?php

namespace App\Controller\v1;

use App\Collections\RealtyCategoriesCollection;
use App\Collections\RealtyTypesCollection;
use App\dto\UpsertCharacteristic;
use App\Entity\ValueObjects\AliasVO;
use App\Entity\ValueObjects\EnumVO;
use App\Entity\ValueObjects\I18nCharFieldsVO;
use App\Entity\ValueObjects\I18nCharVO;
use App\Entity\ValueObjects\SearchPropertyVO;
use App\Enum\CharsTypeEnum;
use App\Enum\InputTypeEnum;
use App\Enum\LangsEnum;
use App\Enum\RealtyTypeEnum;
use App\Exceptions\ValueObjectConstraint;
use App\Interfaces\Chars\IUpsertService;
use App\Interfaces\ValidatableRequest;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class CharacteristicsController implements ValidatableRequest
{
    private NormalizerInterface $normalizer;

    private IUpsertService $upsertService;

    /**
     * @param NormalizerInterface $normalizer
     * @param IUpsertService $upsertService
     */
    public function __construct(NormalizerInterface $normalizer, IUpsertService $upsertService)
    {
        $this->normalizer = $normalizer;
        $this->upsertService = $upsertService;
    }

    /**
     * @Route("/characteristic", name="characteristics_create", methods={"POST"})
     * @param Request $request
     * @return Response
     * @throws ExceptionInterface
     * @throws ValueObjectConstraint
     */
    public function create(Request $request): Response
    {
        $dto = $this->createDto($request);
        $responseDto = $this->upsertService->create($dto);

        return new JsonResponse(
            $this->normalizer->normalize($responseDto)
        );
    }

    /**
     * @param Request $request
     * @return UpsertCharacteristic
     * @throws ValueObjectConstraint
     */
    private function createDto(Request $request): UpsertCharacteristic
    {
        $requestArray = $request->request->all();

        $i18nFields = [];
        foreach (LangsEnum::values() as $lang) {
            $i18nFields[$lang] = new I18nCharFieldsVO(
                $requestArray['i18n'][$lang]['label'],
                $requestArray['i18n'][$lang]['short']
            );
        }
        $i18n = new I18nCharVO($i18nFields);

        $typeValues = $requestArray['property']['search']['types'] ?? [];
        $realtyTypes = new RealtyTypesCollection();
        array_map(fn($type) => $realtyTypes->append($type), $typeValues);

        $categoryValues = $requestArray['property']['search']['categories'] ?? [];
        $categories = new RealtyCategoriesCollection();
        array_map(fn($type) => $categories->append($type), $categoryValues);

        $searchPropertyVo = new SearchPropertyVO(
            $requestArray['property']['search']['sort'] ?? 0,
            $requestArray['property']['search']['input'] ?? 'text',
            $realtyTypes,
            $categories,
            $requestArray['property']['search']['is_secret'] ?? false,
        );

        $formType = new EnumVO($requestArray['type'], CharsTypeEnum::class);

        return new UpsertCharacteristic($i18n, $searchPropertyVo, $formType, new AliasVO($requestArray['attribute']));
    }
}
