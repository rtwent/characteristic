<?php

namespace App\Controller\v1;

use App\dto\CharFilter;
use App\dto\CharOutDtoPlain;
use App\Entity\ValueObjects\UuidVO;
use App\Exceptions\ValueObjectConstraint;
use App\Interfaces\ISelectChars;
use App\Interfaces\Values\ISelectValues;
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

class CharacteristicsController
{
    private ISelectChars $selectService;
    private NormalizerInterface $normalizer;
    private ISelectValues $selectValues;

    /**
     * CharacteristicsController constructor.
     * @param ISelectChars $selectService
     * @param NormalizerInterface $normalizer
     * @param ISelectValues $selectValues
     */
    public function __construct(ISelectChars $selectService, NormalizerInterface $normalizer, ISelectValues $selectValues)
    {
        $this->selectService = $selectService;
        $this->normalizer = $normalizer;
        $this->selectValues = $selectValues;
    }


    /**
     * @Route(
     *     "/characteristic/{uuid}",
     *     name="characteristics_single",
     *     methods={"GET"},
     *     requirements={"uuid": "[0-9a-f]{8}-[0-9a-f]{4}-[4][0-9a-f]{3}-[89ab][0-9a-f]{3}-[0-9a-f]{12}"}
     * )
     *
     * @Operation(
     *     operationId="characteristics_single",
     *     summary="Получение единичной характеристики по id с учетом локали",
     *     @OA\Response(
     *          response="200",
     *          description="Единичная характеристика в зависимости от локали",
     *          @OA\JsonContent(
     *              ref=@Model(type=App\dto\CharOutDtoPlain::class, groups={"char:item:read"})
     *          )
     *      ),
     *      @OA\Response(
     *          response="404",
     *          ref="#/components/responses/NotFound"
     *      ),
     *     @OA\Response(
     *          response="400",
     *          ref="#/components/responses/ValidationFailed"
     *      )
     * )
     *
     * @OA\Tag(name="Характеристики")
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
    public function singleByUuid(string $uuid): Response
    {
        $characteristicDto = $this->selectService->singleChar(new UuidVO($uuid));
        $vocabularyValues = $this->selectValues->getValuesByChar(new UuidVO($uuid));

        $dto = new CharOutDtoPlain(
            $characteristicDto->getId(),
            $characteristicDto->getAlias(),
            $characteristicDto->getType(),
            $characteristicDto->getLabel(),
            $characteristicDto->getShort(),
            $characteristicDto->getSearchProps(),
            $characteristicDto->getMeasurement(),
            $vocabularyValues
        );

        return new JsonResponse($this->normalizer->normalize($dto, null, ['groups' => 'char:item:read']));
    }

    /**
     * @Route(
     *     "/characteristic/raw/{uuid}",
     *     name="characteristics_rawsingle",
     *     methods={"GET"},
     *     requirements={"uuid": "[0-9a-f]{8}-[0-9a-f]{4}-[4][0-9a-f]{3}-[89ab][0-9a-f]{3}-[0-9a-f]{12}"}
     * )
     *
     * @Operation(
     *     operationId="characteristics_raw_single",
     *     summary="Получение единичной характеристики по id без учета локали",
     *     @OA\Response(
     *          response="200",
     *          description="Все поля в единичной характеристике",
     *          @OA\JsonContent(
     *              ref=@Model(type=App\dto\CharOutRawDto::class)
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
     * @OA\Tag(name="Характеристики")
     *
     * @OA\Parameter(
     *     ref="#/components/parameters/PathUuid"
     * )
     *
     * @Security(name="Bearer")
     *
     *
     * @param string $uuid
     * @return Response
     * @throws ExceptionInterface
     * @throws ValueObjectConstraint
     */
    public function singleRaw(string $uuid): Response
    {
        $dto = $this->selectService->rawChar(new UuidVO($uuid));
        return new JsonResponse($this->normalizer->normalize($dto));
    }

    /**
     * @Route(
     *     "/characteristic/all",
     *     name="characteristics_all",
     *     methods={"GET"}
     * )
     *
     * @Operation(
     *     operationId="characteristics_all",
     *     summary="Получение всех характеристик в комбинации с фильтром",
     *     @OA\Response(
     *          response="200",
     *          description="Массив характеристик",
     *          @OA\JsonContent(
     *              type="array",
     *              @OA\Items(
     *                  ref=@Model(type=App\dto\CharOutDto::class)
     *              )
     *          )
     *      ),
     *      @OA\Response(
     *          response="400",
     *          ref="#/components/responses/ValidationFailed"
     *      )
     * )
     *
     * @OA\Tag(name="Характеристики")
     *
     * @OA\Parameter(
     *     ref="#/components/parameters/Language"
     * )
     * @OA\Parameter(
     *     in="query",
     *     name="filter",
     *     description="Фильтр по псевдониму и названию",
     *     example="?filter[aliases][]=localcode&filter[aliases][]=apartment_type&filter[labels][]=нов",
     *     @OA\Schema(
     *          type="string"
     *     )
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
        $charFilterDto = new CharFilter(
            $request->query->get('filter')['aliases'] ?? [],
            $request->query->get('filter')['labels'] ?? []
        );

        $dtoCollection = $this->selectService->collection($charFilterDto);

        return new JsonResponse($this->normalizer->normalize($dtoCollection));
    }
}
