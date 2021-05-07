<?php

namespace App\Controller\v1;

use App\Entity\ValueObjects\UuidVO;
use App\Exceptions\ValueObjectConstraint;
use App\Interfaces\Values\ISelectValues;
use Nelmio\ApiDocBundle\Annotation\Model;
use Nelmio\ApiDocBundle\Annotation\Security;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Nelmio\ApiDocBundle\Annotation\Operation;
use OpenApi\Annotations as OA;

class ValuesController
{
    private ISelectValues $selectService;
    private NormalizerInterface $normalizer;

    /**
     * CharacteristicsController constructor.
     * @param ISelectValues $selectService
     * @param NormalizerInterface $normalizer
     */
    public function __construct(ISelectValues $selectService, NormalizerInterface $normalizer)
    {
        $this->selectService = $selectService;
        $this->normalizer = $normalizer;
    }


    /**
     * @Route(
     *     "/value/{uuid}",
     *     name="values_single",
     *     methods={"GET"},
     *     requirements={"uuid": "[0-9a-f]{8}-[0-9a-f]{4}-[4][0-9a-f]{3}-[89ab][0-9a-f]{3}-[0-9a-f]{12}"}
     * )
     *
     * @Operation(
     *     operationId="values_single",
     *     summary="Получение единичного словарного значения по id с учетом локали",
     *     @OA\Response(
     *          response="200",
     *          description="Единичное словарное значение в зависимости от локали",
     *          @OA\JsonContent(
     *              ref=@Model(type=App\dto\ValueOutDto::class)
     *          )
     *      ),
     *      @OA\Response(
     *          response="404",
     *          ref="#/components/responses/NotFound"
     *      ),
     * )
     *
     * @OA\Tag(name="Словарные данные")
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
     * @param string $uuid has 404
     * @return Response
     * @throws ValueObjectConstraint
     * @throws ExceptionInterface
     */
    public function singleByUuid(string $uuid): Response
    {
        $dto = $this->selectService->singleChar(new UuidVO($uuid));

        return new JsonResponse($this->normalizer->normalize($dto));
    }

}
