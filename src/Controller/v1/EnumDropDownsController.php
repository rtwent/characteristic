<?php

namespace App\Controller\v1;

use App\Collections\DropDownCollection;
use App\dto\DropDownDto;
use App\Enum\CharsTypeEnum;
use App\Enum\InputTypeEnum;
use App\Enum\RealtyTypeEnum;
use App\Enum\SearchCategoriesEnum;
use App\Exceptions\ValueObjectConstraint;
use Nelmio\ApiDocBundle\Annotation\Model;
use Nelmio\ApiDocBundle\Annotation\Security;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Nelmio\ApiDocBundle\Annotation\Operation;
use OpenApi\Annotations as OA;
use Symfony\Contracts\Translation\TranslatorInterface;

class EnumDropDownsController
{
    private TranslatorInterface $translator;
    private NormalizerInterface $normalizer;

    public function __construct(TranslatorInterface $translator, NormalizerInterface $normalizer)
    {
        $this->translator = $translator;
        $this->normalizer = $normalizer;
    }

    /**
     * @Route(
     *     "/dropdown/types",
     *     name="dropdown_types",
     *     methods={"GET"}
     * )
     *
     * @Operation(
     *     operationId="dropdown_types",
     *     summary="Получение выпадающего списка типов характеристик",
     *     @OA\Response(
     *          response="200",
     *          description="Выпадающий список типов характеристик",
     *          @OA\JsonContent(
     *              type="array",
     *              @OA\Items(ref=@Model(type=App\dto\DropDownDto::class))
     *          )
     *      )
     * )
     *
     * @OA\Tag(name="Выпадающие списки")
     *
     * @OA\Parameter(
     *     ref="#/components/parameters/Language"
     * )
     *
     *
     * @Security(name="Bearer")
     *
     * @return Response
     * @throws ExceptionInterface
     * @throws ValueObjectConstraint
     */
    public function charTypes(): Response
    {
        $typesCollection = new DropDownCollection();
        foreach (CharsTypeEnum::values() as $typeAlias) {
            $typesCollection->append(new DropDownDto($typeAlias, $this->translator->trans($typeAlias, [], 'enums')));
        }

        return new JsonResponse($this->normalizer->normalize($typesCollection));
    }

    /**
     * @Route(
     *     "/dropdown/categories",
     *     name="category_types",
     *     methods={"GET"}
     * )
     *
     * @Operation(
     *     operationId="category_types",
     *     summary="Получение выпадающего списка категорий для поиска",
     *     @OA\Response(
     *          response="200",
     *          description="Выпадающий список категорий для поиска",
     *          @OA\JsonContent(
     *              type="array",
     *              @OA\Items(ref=@Model(type=App\dto\DropDownDto::class))
     *          )
     *      )
     * )
     *
     * @OA\Tag(name="Выпадающие списки")
     *
     * @OA\Parameter(
     *     ref="#/components/parameters/Language"
     * )
     *
     *
     * @Security(name="Bearer")
     *
     * @return Response
     * @throws ExceptionInterface
     * @throws ValueObjectConstraint
     */
    public function searchCategories(): Response
    {
        $searchCategoryCollection = new DropDownCollection();
        foreach (SearchCategoriesEnum::values() as $searchCategory) {
            $searchCategoryCollection->append(new DropDownDto($searchCategory, $this->translator->trans($searchCategory, [], 'enums')));
        }

        return new JsonResponse($this->normalizer->normalize($searchCategoryCollection));
    }

    /**
     * @Route(
     *     "/dropdown/realty",
     *     name="realty_types",
     *     methods={"GET"}
     * )
     *
     * @Operation(
     *     operationId="realty_types",
     *     summary="Получение выпадающего списка видов недвижимости",
     *     @OA\Response(
     *          response="200",
     *          description="Выпадающий список видов недвижимости",
     *          @OA\JsonContent(
     *              type="array",
     *              @OA\Items(ref=@Model(type=App\dto\DropDownDto::class))
     *          )
     *      )
     * )
     *
     * @OA\Tag(name="Выпадающие списки")
     *
     * @OA\Parameter(
     *     ref="#/components/parameters/Language"
     * )
     *
     *
     * @Security(name="Bearer")
     *
     * @return Response
     * @throws ExceptionInterface
     * @throws ValueObjectConstraint
     */
    public function realtyTypes(): Response
    {
        $realtyTypesCollection = new DropDownCollection();
        foreach (RealtyTypeEnum::values() as $realtyType) {
            $realtyTypesCollection->append(new DropDownDto($realtyType, $this->translator->trans($realtyType, [], 'enums')));
        }

        return new JsonResponse($this->normalizer->normalize($realtyTypesCollection));
    }

    /**
     * @Route(
     *     "/dropdown/input",
     *     name="input_types",
     *     methods={"GET"}
     * )
     *
     * @Operation(
     *     operationId="input_types",
     *     summary="Получение выпадающего списка типов инпутов",
     *     @OA\Response(
     *          response="200",
     *          description="Выпадающий список типов инпутов",
     *          @OA\JsonContent(
     *              type="array",
     *              @OA\Items(ref=@Model(type=App\dto\DropDownDto::class))
     *          )
     *      )
     * )
     *
     * @OA\Tag(name="Выпадающие списки")
     *
     * @OA\Parameter(
     *     ref="#/components/parameters/Language"
     * )
     *
     *
     * @Security(name="Bearer")
     *
     * @return Response
     * @throws ExceptionInterface
     * @throws ValueObjectConstraint
     */
    public function inputTypes(): Response
    {
        $inputTypesCollection = new DropDownCollection();
        foreach (InputTypeEnum::values() as $inputType) {
            $inputTypesCollection->append(new DropDownDto($inputType, $this->translator->trans($inputType, [], 'enums')));
        }

        return new JsonResponse($this->normalizer->normalize($inputTypesCollection));
    }

}
