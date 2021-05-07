<?php

namespace App\Controller\v1;

use App\Collections\RealtyTypesCollection;
use App\Collections\RepCharValuesCollection;
use App\dto\RepCharValuesOutDto;
use App\dto\Response202Dto;
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
use Nelmio\ApiDocBundle\Annotation\Operation;
use Nelmio\ApiDocBundle\Annotation\Security;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Annotations as OA;

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
     * @Operation(
     *     operationId="representation_values_insert",
     *     summary="Внесение характеристики и значений характеристики для представительства",
     *     @OA\Response(
     *          response="200",
     *          description="Единичная характеристика со значениями в зависимости от локали",
     *          @OA\JsonContent(
     *              ref=@Model(type=App\dto\RepCharValuesOutDto::class)
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
     *     description="Payload для создания, обновления характеристикис привязкой к представительству",
     *     @OA\MediaType(
     *          mediaType="application/json",
     *          @OA\Schema(
     *              ref=@Model(type=App\dto\UpsertCharValuesDto::class)
     *          )
     *     )
     * )
     *
     * @OA\Tag(name="Наборы для представительств")
     *
     * @Security(name="Bearer")
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
     * @Operation(
     *     operationId="representation_values_update",
     *     summary="Обновление характеристики и значений характеристики для представительства",
     *     @OA\Response(
     *          response="200",
     *          description="Единичная характеристика со значениями в зависимости от локали",
     *          @OA\JsonContent(
     *              ref=@Model(type=App\dto\RepCharValuesOutDto::class)
     *          )
     *      ),
     *      @OA\Response(
     *          response="400",
     *          ref="#/components/responses/ValidationFailed"
     *      )
     * )
     *
     * @OA\Parameter(
     *     in="path",
     *     name="id",
     *     description="Id записи",
     *     required=true,
     *     @OA\Schema(
     *          type="integer",
     *          example=1
     *     )
     * )
     * @OA\Parameter(
     *     ref="#/components/parameters/Language"
     * )
     *
     * @OA\RequestBody(
     *     required=true,
     *     description="Payload для создания, обновления характеристикис привязкой к представительству",
     *     @OA\MediaType(
     *          mediaType="application/json",
     *          @OA\Schema(
     *              ref=@Model(type=App\dto\UpsertCharValuesDto::class)
     *          )
     *     )
     * )
     *
     * @OA\Tag(name="Наборы для представительств")
     *
     * @Security(name="Bearer")
     *
     * @param int $id
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
     * @Route(
     *     "/repvalues/{id}",
     *     name="representation_values_delete",
     *     methods={"DELETE"},
     *     requirements={
     *          "id": "[0-9]+"
     *     }
     * )
     *
     * @Operation(
     *     operationId="representation_values_delete",
     *     summary="Удаление характеристики и значений характеристики для представительства",
     *     @OA\Response(
     *          response="202",
     *          ref="#/components/responses/Accepted"
     *      ),
     *      @OA\Response(
     *          response="404",
     *          ref="#/components/responses/NotFound"
     *      ),
     *      @OA\Response(
     *          response="400",
     *          ref="#/components/responses/ValidationFailed"
     *      )
     * )
     *
     * @OA\Parameter(
     *     in="path",
     *     name="id",
     *     description="Id записи для удаления",
     *     required=true,
     *     @OA\Schema(
     *          type="integer",
     *          example=1
     *     )
     * )
     *
     * @OA\Tag(name="Наборы для представительств")
     *
     * @Security(name="Bearer")
     *
     * @param int $id
     * @return Response
     * @throws ExceptionInterface
     */
    public function remove(int $id): Response
    {
        $this->upsertService->delete($id);

        return new JsonResponse(
            $this->normalizer->normalize(new Response202Dto()),
            Response::HTTP_ACCEPTED
        );
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
