<?php

namespace App\Controller\v1;

use App\dto\Response202Dto;
use App\dto\UpsertMeasureUnit;
use App\Entity\ValueObjects\I18nMeasureUnitsFieldsVO;
use App\Entity\ValueObjects\I18nMeasureUnitsVO;
use App\Entity\ValueObjects\UuidVO;
use App\Enum\LangsEnum;
use App\Exceptions\ValueObjectConstraint;
use App\Interfaces\MeasureUnits\IUnitsService;
use App\Interfaces\ValidatableRequest;
use Nelmio\ApiDocBundle\Annotation\Model;
use Nelmio\ApiDocBundle\Annotation\Operation;
use Nelmio\ApiDocBundle\Annotation\Security;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use OpenApi\Annotations as OA;

class MeasureUnitsController implements ValidatableRequest
{
    private IUnitsService $unitsService;
    private NormalizerInterface $normalizer;

    /**
     * CharacteristicsController constructor.
     * @param IUnitsService $unitsService
     * @param NormalizerInterface $normalizer
     */
    public function __construct(IUnitsService $unitsService, NormalizerInterface $normalizer)
    {
        $this->unitsService = $unitsService;
        $this->normalizer = $normalizer;
    }


    /**
     * @Route(
     *     "/units/{id}",
     *     name="units_rawsingle",
     *     methods={"GET"},
     *     requirements={"id": "[0-9]+"}
     * )
     *
     * @Operation(
     *     operationId="units_raw_single",
     *     summary="Получение единичной единицы измерения по id без учета локали",
     *     @OA\Response(
     *          response="200",
     *          description="Все поля в единичной единице измерения",
     *          @OA\JsonContent(
     *              ref=@Model(type=App\dto\MeasureUnitRawOutDto::class)
     *          )
     *      ),
     *      @OA\Response(
     *          response="404",
     *          ref="#/components/responses/NotFound"
     *      ),
     * )
     *
     * @OA\Tag(name="Единицы измерения")
     *
     * @OA\Parameter(
     *     in="path",
     *     name="id",
     *     description="Локальный айди единицы измерения",
     *     required=true,
     *     example="2"
     * )
     *
     * @Security(name="Bearer")
     *
     *
     * @param int $id
     * @return Response
     * @throws ExceptionInterface
     */
    public function singleRaw(int $id): Response
    {
        $dto = $this->unitsService->raw($id);
        return new JsonResponse($this->normalizer->normalize($dto));
    }

    /**
     * @Route(
     *     "/units/all",
     *     name="units_all",
     *     methods={"GET"}
     * )
     *
     * @Operation(
     *     operationId="units_all",
     *     summary="Получение всех единиц измерения характеристик",
     *     @OA\Response(
     *          response="200",
     *          description="Массив единиц измереия",
     *          @OA\JsonContent(
     *              type="array",
     *              @OA\Items(
     *                  ref=@Model(type=App\dto\MeasureUnitOutDto::class)
     *              )
     *          )
     *      )
     * )
     *
     * @OA\Tag(name="Единицы измерения")
     *
     * @OA\Parameter(
     *     ref="#/components/parameters/Language"
     * )
     *
     * @Security(name="Bearer")
     *
     * @param Request $request
     * @return Response
     * @throws ExceptionInterface
     */
    public function collection(Request $request): Response
    {
        $dtoCollection = $this->unitsService->collection();

        return new JsonResponse($this->normalizer->normalize($dtoCollection));
    }

    /**
     * @Route("/units", name="units_create", methods={"POST"})
     *
     * @Operation(
     *     operationId="units_create",
     *     summary="Создание единицы измерения",
     *     @OA\Response(
     *          response="200",
     *          description="Единичная единица измерения в зависимости от локали",
     *          @OA\JsonContent(
     *              ref=@Model(type=App\dto\MeasureUnitOutDto::class)
     *          )
     *      ),
     *      @OA\Response(
     *          response="400",
     *          ref="#/components/responses/ValidationFailed"
     *      )
     * )
     *
     *
     * @OA\RequestBody(
     *     ref="#/components/requestBodies/UpsertMeasureUnit"
     * )
     *
     * @OA\Tag(name="Единицы измерения")
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
        $responseDto = $this->unitsService->create($dto);

        return new JsonResponse(
            $this->normalizer->normalize($responseDto)
        );
    }


    /**
     * @Route(
     *     "/units/{id}",
     *     name="units_update",
     *     methods={"PUT"},
     *     requirements={"id": "[0-9]+"}
     * )
     *
     * @Operation(
     *     operationId="units_update",
     *     summary="Изменение единицы измерения",
     *     @OA\Response(
     *          response="200",
     *          description="Единичная единица измерения в зависимости от локали",
     *          @OA\JsonContent(
     *              ref=@Model(type=App\dto\MeasureUnitOutDto::class)
     *          )
     *      ),
     *      @OA\Response(
     *          response="400",
     *          ref="#/components/responses/ValidationFailed"
     *      )
     * )
     *
     * @OA\Parameter(
     *     ref="#/components/parameters/PathId"
     * )
     *
     *
     * @OA\RequestBody(
     *     ref="#/components/requestBodies/UpsertMeasureUnit"
     * )
     *
     * @OA\Tag(name="Единицы измерения")
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
        $responseDto = $this->unitsService->update($id, $dto);

        return new JsonResponse(
            $this->normalizer->normalize($responseDto)
        );
    }

    /**
     * @param Request $request
     * @return UpsertMeasureUnit
     * @throws ValueObjectConstraint
     */
    private function createDto(Request $request): UpsertMeasureUnit
    {
        $requestArray = $request->request->all();

        $i18nFields = [];
        foreach (LangsEnum::values() as $lang) {
            $i18nFields[$lang] = new I18nMeasureUnitsFieldsVO(
                $requestArray['i18n'][$lang]['label']
            );
        }
        $i18n = new I18nMeasureUnitsVO($i18nFields);

        $siName = $requestArray['siName'];

        return new UpsertMeasureUnit($siName, $i18n);
    }

    /**
     * @Route(
     *     "/units/{id}",
     *     name="measureunits_remove",
     *     methods={"DELETE"},
     *     requirements={"id": "[0-9]+"}
     * )
     *
     * @Operation(
     *     operationId="measureunits_remove",
     *     summary="Удаление единицы измерения",
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
     *     ref="#/components/parameters/PathId"
     * )
     *
     *
     * @OA\Tag(name="Единицы измерения")
     *
     * @param int $id
     * @return Response
     * @throws ExceptionInterface
     */
    public function delete(int $id): Response
    {
        $this->unitsService->delete($id);

        return new JsonResponse(
            $this->normalizer->normalize(new Response202Dto()),
            Response::HTTP_ACCEPTED
        );
    }
}
