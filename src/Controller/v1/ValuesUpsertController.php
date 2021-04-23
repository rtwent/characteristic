<?php

namespace App\Controller\v1;

use App\Collections\RealtyCategoriesCollection;
use App\Collections\RealtyTypesCollection;
use App\dto\Response202Dto;
use App\dto\UpsertCharacteristic;
use App\Entity\ValueObjects\AliasVO;
use App\Entity\ValueObjects\EnumVO;
use App\Entity\ValueObjects\I18nCharFieldsVO;
use App\Entity\ValueObjects\I18nCharVO;
use App\Entity\ValueObjects\SearchPropertyVO;
use App\Entity\ValueObjects\UuidVO;
use App\Enum\CharsTypeEnum;
use App\Enum\LangsEnum;
use App\Exceptions\ValueObjectConstraint;
use App\Interfaces\Chars\IUpsertService;
use App\Interfaces\ValidatableRequest;
use App\Interfaces\Values\IUpsertValues;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Uid\Uuid;

class ValuesUpsertController implements ValidatableRequest
{
    private NormalizerInterface $normalizer;

    private IUpsertValues $upsertService;

    /**
     * @param NormalizerInterface $normalizer
     * @param IUpsertValues $upsertService
     */
    public function __construct(NormalizerInterface $normalizer, IUpsertValues $upsertService)
    {
        $this->normalizer = $normalizer;
        $this->upsertService = $upsertService;
    }

    /**
     * @Route("/value", name="values_create", methods={"POST", "GET"})
     * @param Request $request
     * @return Response
     * @throws ExceptionInterface
     * @throws ValueObjectConstraint
     */
    public function create(Request $request): Response
    {
        echo '<pre>';
        var_dump(__FILE__);
        exit();
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
