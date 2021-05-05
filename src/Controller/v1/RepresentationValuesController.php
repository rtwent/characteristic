<?php

namespace App\Controller\v1;

use App\Collections\RealtyTypesCollection;
use App\Collections\RepCharValuesCollection;
use App\dto\UpsertCharValuesDto;
use App\Entity\ValueObjects\RepCharValueSettingsVO;
use App\Entity\ValueObjects\RepCharValuesVO;
use App\Entity\ValueObjects\UuidVO;
use App\Exceptions\ValueObjectConstraint;
use App\Interfaces\RepresentationValues\IRepresentationValues;
use App\Interfaces\ValidatableRequest;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class RepresentationValuesController implements ValidatableRequest
{
    private IRepresentationValues $upsertService;
    private NormalizerInterface $normalizer;

    /**
     * CharacteristicsController constructor.
     * @param IRepresentationValues $upsertService
     * @param NormalizerInterface $normalizer
     */
    public function __construct(IRepresentationValues $upsertService, NormalizerInterface $normalizer)
    {
        $this->upsertService = $upsertService;
        $this->normalizer = $normalizer;
    }


    /**
     * @Route(
     *     "/repvalues",
     *     name="representation_values_insert",
     *     methods={"POST"},
     * )
     *
     * @param Request $request
     * @return Response
     * @throws ExceptionInterface
     * @throws ValueObjectConstraint
     */
    public function insert(Request $request): Response
    {
        $dto = $this->createDto($request);
        $result = $this->upsertService->create($dto);

        return new JsonResponse($this->normalizer->normalize($result, null, ['groups' => 'repCharValues']));
    }

    /**
     * @Route(
     *     "/repvalues/{id}",
     *     name="representation_values_update",
     *     methods={"PUT"},
     *     requirements={"id" : "\d+"}
     * )
     *
     * @param Request $request
     * @return Response
     * @throws ExceptionInterface
     * @throws ValueObjectConstraint
     */
    public function update(int $id, Request $request): Response
    {
        $dto = $this->createDto($request);
        $result = $this->upsertService->update($id, $dto);

        return new JsonResponse($this->normalizer->normalize($result, null, ['groups' => 'repCharValues']));
    }

    /**
     * @param Request $request
     * @return UpsertCharValuesDto
     * @throws ValueObjectConstraint
     */
    private function createDto(Request $request): UpsertCharValuesDto
    {
        $requestArray = $request->request->all();

        $charValues = $requestArray['char_values'] ?? [];
        $repCharValues = new RepCharValuesCollection();
        foreach ($charValues as $charValue) {
            $vo = new RepCharValuesVO($charValue['value_uuid'] ?? '', $charValue['sort'] ?? 0);
            $repCharValues->append($vo);
        }

        $settings = $requestArray['settings'] ?? [];

        $realtyTypesCollection = new RealtyTypesCollection();
        $realtyTypes = $settings['types'] ?? [];
        foreach ($realtyTypes as $realtyType) {
            $realtyTypesCollection->append($realtyType);
        }

        $settingsVo = new RepCharValueSettingsVO(
            $settings['rowId'] ?? 0,
            $settings['rowOrder'] ?? 0,
            $realtyTypesCollection
        );

        return new UpsertCharValuesDto(
            new UuidVO($requestArray['rep_uuid'] ?? ''),
            new UuidVO($requestArray['char_uuid'] ?? ''),
            $repCharValues,
            $settingsVo
        );
    }
}
