<?php

namespace App\Controller\v1;

use App\Collections\RepCharValuesCollection;
use App\dto\UpsertCharValuesDto;
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
        $this->upsertService->create($dto);

        return new JsonResponse($this->normalizer->normalize($dto));
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

        return new UpsertCharValuesDto(
            new UuidVO($requestArray['rep_uuid'] ?? ''),
            new UuidVO($requestArray['char_uuid'] ?? ''),
            $repCharValues
        );
    }
}
