<?php

namespace App\Controller\v1;

use App\dto\ValuesBySearchCategories;
use App\Entity\ValueObjects\RealtyTypeVO;
use App\Entity\ValueObjects\UuidVO;
use App\Enum\RealtyTypeEnum;
use App\Enum\SearchCategoriesEnum;
use App\Exceptions\ValueObjectConstraint;
use App\Interfaces\Representations\ISelectRepresentation;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Nelmio\ApiDocBundle\Annotation\Operation;
use Nelmio\ApiDocBundle\Annotation\Security;
use OpenApi\Annotations as OA;
use Nelmio\ApiDocBundle\Annotation\Model;

class RepresentationController
{
    private ISelectRepresentation $selectService;
    private NormalizerInterface $normalizer;

    /**
     * CharacteristicsController constructor.
     * @param ISelectRepresentation $selectService
     * @param NormalizerInterface $normalizer
     */
    public function __construct(ISelectRepresentation $selectService, NormalizerInterface $normalizer)
    {
        $this->selectService = $selectService;
        $this->normalizer = $normalizer;
    }

    /**
     * @Route(
     *     "/rep/bychar/{repUuid}/{charUuid}",
     *     name="representation_valuesbychar",
     *     methods={"GET"},
     *     requirements={
     *      "repUuid": "[0-9a-f]{8}-[0-9a-f]{4}-[4][0-9a-f]{3}-[89ab][0-9a-f]{3}-[0-9a-f]{12}",
     *      "charUuid": "[0-9a-f]{8}-[0-9a-f]{4}-[4][0-9a-f]{3}-[89ab][0-9a-f]{3}-[0-9a-f]{12}"
     *     }
     * )
     *
     * @Operation(
     *     operationId="representation_valuesbychar",
     *     summary="Получение списка значений для характеристики на основе представительства",
     *     @OA\Response(
     *          response="200",
     *          description="Набор характеристик и их значений в зависимости от локали",
     *          @OA\JsonContent(
     *                  ref=@Model(type=App\dto\CharWithValuesOutDto::class, groups={"repCharValues"})
     *          )
     *      ),
     *      @OA\Response(
     *          response="404",
     *          ref="#/components/responses/NotFound",
     *          description="Throws 'Representation was not found' if representation OR characteristic was not found"
     *      ),
     *      @OA\Response(
     *          response="400",
     *          ref="#/components/responses/ValidationFailed"
     *      )
     * )
     *
     * @OA\Tag(name="Наборы для представительств")
     *
     * @OA\Parameter(
     *     ref="#/components/parameters/PathUuidRepresentation"
     * )
     * @OA\Parameter(
     *     ref="#/components/parameters/PathUuidChar"
     * )
     * @OA\Parameter(
     *     ref="#/components/parameters/Language"
     * )
     *
     * @Security(name="Bearer")
     *
     * @param string $repUuid
     * @param string $charUuid
     * @return Response
     * @throws ExceptionInterface
     * @throws ValueObjectConstraint
     */
    public function valuesByCharAndRepresentation(string $repUuid, string $charUuid): Response
    {
        $dto = $this->selectService->valuesByCharacteristic(
            new UuidVO($repUuid),
            new UuidVO($charUuid)
        );

        return new JsonResponse($this->normalizer->normalize($dto , null, ['groups' => 'repCharValues']));
    }

    /**
     * @Route(
     *     "/rep/bysearchtype/{repUuid}/{searchCategoryType}",
     *     name="representation_bysearchtype",
     *     methods={"GET"},
     *     requirements={
     *      "repUuid": "[0-9a-f]{8}-[0-9a-f]{4}-[4][0-9a-f]{3}-[89ab][0-9a-f]{3}-[0-9a-f]{12}",
     *      "searchCategoryType": "[-a-z]+"
     *     }
     * )
     *
     * @Operation(
     *     operationId="representation_bysearchtype",
     *     summary="Получение списка значений для характеристики на основе представительства, категории поиска и типа недвижимости",
     *     @OA\Response(
     *          response="200",
     *          description="Набор характеристик и их значений в зависимости от локали",
     *          @OA\JsonContent(
     *              type="array",
     *              @OA\Items(
     *                  ref=@Model(type=App\dto\CharWithValuesOutDto::class, groups={"repCharValues"})
     *              )
     *          )
     *      ),
     *      @OA\Response(
     *          response="404",
     *          ref="#/components/responses/NotFound",
     *          description="Throws 'Representation was not found' if representation OR characteristic was not found"
     *      ),
     *      @OA\Response(
     *          response="400",
     *          ref="#/components/responses/ValidationFailed"
     *      )
     * )
     *
     * @OA\Tag(name="Наборы для представительств")
     *
     * @OA\Parameter(
     *     ref="#/components/parameters/PathUuidRepresentation"
     * )
     * @OA\Parameter(
     *     in="path",
     *     name="searchCategoryType",
     *     description="Категория поиска",
     *     required=true,
     *     @OA\Schema(
     *          ref="#/components/schemas/SearchCategoryEnum"
     *     )
     * )
     *
     * @OA\Parameter(
     *     in="query",
     *     name="realtyType",
     *     description="Тип недвижимости",
     *     @OA\Schema(
     *          ref="#/components/schemas/RealtyTypeEnum"
     *     )
     * )
     * @OA\Parameter(
     *     ref="#/components/parameters/Language"
     * )
     *
     * @Security(name="Bearer")
     *
     * @param string $repUuid
     * @param string $searchCategoryType
     * @param Request $request
     * @return Response
     * @throws ExceptionInterface
     * @throws ValueObjectConstraint
     */
    public function allBySearchCategory(string $repUuid, string $searchCategoryType, Request $request): Response
    {
        $userRealtyType = $request->get('realtyType', '');
        $realtyType = null;
        if ($userRealtyType !== '') {
            $realtyType = RealtyTypeEnum::get($userRealtyType);
        }

        $dto = new ValuesBySearchCategories(
            new UuidVO($repUuid),
            SearchCategoriesEnum::get($searchCategoryType),
            $realtyType
        );

        $dto = $this->selectService->valuesBySearchCategory($dto);

        return new JsonResponse($this->normalizer->normalize($dto, null, ['groups' => 'repCharValues']));
    }


    /**
     * @Route(
     *     "/rep/allchars/{uuid}",
     *     name="representation_allchars_single",
     *     methods={"GET"},
     *     requirements={"uuid": "[0-9a-f]{8}-[0-9a-f]{4}-[4][0-9a-f]{3}-[89ab][0-9a-f]{3}-[0-9a-f]{12}"}
     * )
     *
     * @Operation(
     *     operationId="representation_allchars_single",
     *     summary="Получение списка всех характеристик для представительства",
     *     @OA\Response(
     *          response="200",
     *          description="Набор характеристик и их значений в зависимости от локали",
     *          @OA\JsonContent(
     *              type="array",
     *              @OA\Items(
     *                  ref=@Model(type=App\dto\CharWithValuesOutDto::class, groups={"repCharValues"})
     *              )
     *          )
     *      ),
     *      @OA\Response(
     *          response="404",
     *          ref="#/components/responses/NotFound",
     *          description="Throws 'Representation was not found' if representation OR characteristic was not found"
     *      ),
     *      @OA\Response(
     *          response="400",
     *          ref="#/components/responses/ValidationFailed"
     *      )
     * )
     *
     * @OA\Tag(name="Наборы для представительств")
     *
     * @OA\Parameter(
     *     ref="#/components/parameters/PathUuid"
     * )
     * @OA\Parameter(
     *     ref="#/components/parameters/Language"
     * )
     *
     * @Security(name="Bearer")
     *
     * @param string $uuid
     * @return Response
     * @throws ValueObjectConstraint
     * @throws ExceptionInterface
     */
    public function allByUuid(string $uuid): Response
    {
        $dto = $this->selectService->allChars(new UuidVO($uuid));

        return new JsonResponse($this->normalizer->normalize($dto, null, ['groups' => 'repCharValues']));
    }

    /**
     * @Route(
     *     "/rep/byrealtytype/{uuid}/{realtyType}",
     *     name="representation_allchars_by_realty_single",
     *     methods={"GET"},
     *     requirements={
     *      "uuid": "[0-9a-f]{8}-[0-9a-f]{4}-[4][0-9a-f]{3}-[89ab][0-9a-f]{3}-[0-9a-f]{12}",
     *      "realtytype": "[-a-z]+"
     *     }
     * )
     *
     * @Operation(
     *     operationId="representation_allchars_by_realty_single",
     *     summary="Получение списка всех характеристик для представительства в зависимости от типа недвижимости",
     *     @OA\Response(
     *          response="200",
     *          description="Набор характеристик и их значений в зависимости от локали",
     *          @OA\JsonContent(
     *              type="array",
     *              @OA\Items(
     *                  ref=@Model(type=App\dto\CharWithValuesOutDto::class, groups={"repCharValues"})
     *              )
     *          )
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
     * @OA\Tag(name="Наборы для представительств")
     *
     * @OA\Parameter(
     *     ref="#/components/parameters/PathUuid"
     * )
     * @OA\Parameter(
     *     required=true,
     *     in="path",
     *     description="Тип недвижимости",
     *     name="realtyType",
     *     @OA\Schema(
     *          ref="#/components/schemas/RealtyTypeEnum"
     *     )
     * )
     * @OA\Parameter(
     *     ref="#/components/parameters/Language"
     * )
     *
     * @Security(name="Bearer")
     *
     * @param string $uuid
     * @param string $realtyType
     * @return Response
     * @throws ExceptionInterface
     * @throws ValueObjectConstraint
     */
    public function byRealtyType(string $uuid, string $realtyType): Response
    {
        $dto = $this->selectService->allCharsByRealtyType(new UuidVO($uuid), new RealtyTypeVO($realtyType));

        return new JsonResponse($this->normalizer->normalize($dto, null, ['groups' => 'repCharValues']));
    }


}
