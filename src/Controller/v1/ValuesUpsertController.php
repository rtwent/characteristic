<?php

namespace App\Controller\v1;

use App\dto\Response202Dto;
use App\dto\UpsertValue;
use App\dto\ValueOutDto;
use App\Entity\ValueObjects\I18nValuesFieldsVO;
use App\Entity\ValueObjects\I18nValuesVO;
use App\Entity\ValueObjects\RealtyTypesVO;
use App\Entity\ValueObjects\UuidVO;
use App\Enum\LangsEnum;
use App\Exceptions\ValueObjectConstraint;
use App\Interfaces\ValidatableRequest;
use App\Interfaces\Values\IUpsertValues;
use Nelmio\ApiDocBundle\Annotation\Model;
use Nelmio\ApiDocBundle\Annotation\Security;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Nelmio\ApiDocBundle\Annotation\Operation;
use OpenApi\Annotations as OA;

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
     * @Route("/value", name="values_create", methods={"POST"})
     *
     * @Operation(
     *     operationId="values_create",
     *     summary="Внесение значения характеристики",
     *     @OA\Response(
     *          response="200",
     *          description="Единичная характеристика со значениями в зависимости от локали",
     *          @OA\JsonContent(
     *              ref=@Model(type=App\dto\ValueOutDto::class)
     *          )
     *      ),
     *      @OA\Response(
     *          response="400",
     *          ref="#/components/responses/ValidationFailed"
     *      )
     * )
     *
     * @OA\Parameter(
     *     ref="#/components/parameters/Language"
     * )
     *
     * @OA\RequestBody(
     *     required=true,
     *     description="Payload для создания, обновления характеристики",
     *     @OA\MediaType(
     *          mediaType="application/json",
     *          @OA\Schema(
     *              ref=@Model(type=App\dto\UpsertValue::class)
     *          )
     *     )
     * )
     *
     * @OA\Tag(name="Словарные данные")
     *
     * @Security(name="Bearer")
     *
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
     * @Route(
     *     "/value/{uuid}",
     *     name="values_update",
     *     methods={"PUT"},
     *     requirements={"uuid": "[0-9a-f]{8}-[0-9a-f]{4}-[4][0-9a-f]{3}-[89ab][0-9a-f]{3}-[0-9a-f]{12}"}
     * )
     *
     * @Operation(
     *     operationId="values_update",
     *     summary="Обновление значения характеристики",
     *     @OA\Response(
     *          response="200",
     *          description="Единичная характеристика со значениями в зависимости от локали",
     *          @OA\JsonContent(
     *              ref=@Model(type=App\dto\ValueOutDto::class)
     *          )
     *      ),
     *      @OA\Response(
     *          response="400",
     *          ref="#/components/responses/ValidationFailed"
     *      ),
     *      @OA\Response(
     *          response="404",
     *          ref="#/components/responses/NotFound"
     *      )
     * )
     *
     * @OA\Parameter(
     *     ref="#/components/parameters/PathUuid"
     * )
     * @OA\Parameter(
     *     ref="#/components/parameters/Language"
     * )
     *
     * @OA\RequestBody(
     *     required=true,
     *     description="Payload для создания, обновления характеристики",
     *     @OA\MediaType(
     *          mediaType="application/json",
     *          @OA\Schema(
     *              ref=@Model(type=App\dto\UpsertValue::class)
     *          )
     *     )
     * )
     *
     * @OA\Tag(name="Словарные данные")
     *
     * @Security(name="Bearer")
     *
     * @param Request $request
     * @param string $uuid
     * @return Response has 404
     * @throws ExceptionInterface
     * @throws ValueObjectConstraint
     */
    public function update(Request $request, string $uuid): Response
    {
        $dto = $this->createDto($request);
        $responseDto = $this->upsertService->update($dto, new UuidVO($uuid));

        return new JsonResponse(
            $this->normalizer->normalize($responseDto)
        );
    }

    /**
     * @Route(
     *     "/value/{uuid}",
     *     name="values_delete",
     *     methods={"DELETE"},
     *     requirements={"uuid": "[0-9a-f]{8}-[0-9a-f]{4}-[4][0-9a-f]{3}-[89ab][0-9a-f]{3}-[0-9a-f]{12}"}
     * )
     *
     * @Operation(
     *     operationId="values_delete",
     *     summary="Обновление значения характеристики",
     *     @OA\Response(
     *          response="202",
     *          ref="#/components/responses/Accepted"
     *      ),
     *      @OA\Response(
     *          response="400",
     *          ref="#/components/responses/ValidationFailed"
     *      ),
     *      @OA\Response(
     *          response="404",
     *          ref="#/components/responses/NotFound"
     *      )
     * )
     *
     * @OA\Parameter(
     *     ref="#/components/parameters/PathUuid"
     * )
     *
     * @OA\Tag(name="Словарные данные")
     *
     * @Security(name="Bearer")
     *
     * @param string $uuid
     * @return Response has 404
     * @throws ExceptionInterface
     * @throws ValueObjectConstraint
     */
    public function delete(string $uuid): Response
    {
        $this->upsertService->delete(new UuidVO($uuid));

        return new JsonResponse(
            $this->normalizer->normalize(new Response202Dto(), Response::HTTP_ACCEPTED)
        );
    }

    /**
     * @param Request $request
     * @return UpsertValue
     * @throws ValueObjectConstraint
     */
    private function createDto(Request $request): UpsertValue
    {
        $requestArray = $request->request->all();

        $uuid = new UuidVO($requestArray['fk_char'] ?? '');

        $i18nFields = [];
        foreach (LangsEnum::values() as $lang) {
            $i18nFields[$lang] = new I18nValuesFieldsVO(
                $requestArray['i18n'][$lang]['label']
            );
        }
        $i18n = new I18nValuesVO($i18nFields);

        return new UpsertValue(
            $uuid,
            $i18n,
            $requestArray['key'] ?? 0,
            $requestArray['default_sort'] ?? 0,
            new RealtyTypesVO($requestArray['only_type'])
        );
    }
}
