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
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use OpenApi\Annotations as OA;
use Nelmio\ApiDocBundle\Annotation\Operation;
use Nelmio\ApiDocBundle\Annotation\Security;
use Nelmio\ApiDocBundle\Annotation\Model;

class CharacteristicsUpsertController implements ValidatableRequest
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
     *
     * @Operation(
     *     operationId="characteristics_create",
     *     summary="Создание характеристики",
     *     @OA\Response(
     *          response="200",
     *          description="Единичная характеристика в зависимости от локали",
     *          @OA\JsonContent(
     *              ref=@Model(type=App\dto\CharOutDto::class)
     *          )
     *      )
     * )
     *
     * @OA\Parameter(
     *     ref="#/components/parameters/Language"
     * )
     *
     * @OA\RequestBody(
     *     ref="#/components/requestBodies/CharsUpsert"
     * )
     *
     * @OA\Tag(name="Характеристики")
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
     *     "/characteristic/{uuid}",
     *     name="characteristics_update",
     *     methods={"PUT"},
     *     requirements={"uuid": "[0-9a-f]{8}-[0-9a-f]{4}-[4][0-9a-f]{3}-[89ab][0-9a-f]{3}-[0-9a-f]{12}"}
     * )
     *
     * @Operation(
     *     operationId="characteristics_update",
     *     summary="Редактирование характеристики",
     *     @OA\Response(
     *          response="200",
     *          description="Единичная характеристика в зависимости от локали",
     *          @OA\JsonContent(
     *              ref=@Model(type=App\dto\CharOutDto::class)
     *          )
     *      ),
     *      @OA\Response(
     *          response="404",
     *          ref="#/components/responses/NotFound"
     *      )
     * )
     *
     * @OA\Parameter(
     *     ref="#/components/parameters/Language"
     * )
     *
     * @OA\Parameter(
     *     ref="#/components/parameters/PathUuid"
     * )
     *
     * @OA\RequestBody(
     *     ref="#/components/requestBodies/CharsUpsert"
     * )
     *
     * @OA\Tag(name="Характеристики")
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
        $uuidVo = new UuidVO($uuid);
        $responseDto = $this->upsertService->update($this->createDto($request), $uuidVo);

        return new JsonResponse(
            $this->normalizer->normalize($responseDto)
        );
    }

    /**
     * @Route(
     *     "/characteristic/{uuid}",
     *     name="characteristics_remove",
     *     methods={"DELETE"},
     *     requirements={"uuid": "[0-9a-f]{8}-[0-9a-f]{4}-[4][0-9a-f]{3}-[89ab][0-9a-f]{3}-[0-9a-f]{12}"}
     * )
     *
     * @Operation(
     *     operationId="characteristics_remove",
     *     summary="Удаление характеристики",
     *     @OA\Response(
     *          response="202",
     *          ref="#/components/responses/Accepted"
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
     *
     * @OA\Tag(name="Характеристики")
     *
     * @param string $uuid
     * @return Response
     * @throws ExceptionInterface
     * @throws ValueObjectConstraint
     */
    public function delete(string $uuid): Response
    {
        $uuidVo = new UuidVO($uuid);
        $this->upsertService->delete($uuidVo);

        return new JsonResponse(
            $this->normalizer->normalize(new Response202Dto()),
            Response::HTTP_ACCEPTED
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
            $requestArray['property']['search']['secret'] ?? false,
        );

        $formType = new EnumVO($requestArray['fieldType'], CharsTypeEnum::class);

        return new UpsertCharacteristic($i18n, $searchPropertyVo, $formType, new AliasVO($requestArray['attrName']));
    }
}
