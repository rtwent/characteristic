<?php

namespace App\Controller\v1;

use App\dto\CharFilter;
use App\Entity\ValueObjects\UuidVO;
use App\Exceptions\ValueObjectConstraint;
use App\Interfaces\ISelectChars;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class CharacteristicsController
{
    private ISelectChars $selectService;
    private NormalizerInterface $normalizer;

    /**
     * CharacteristicsController constructor.
     * @param ISelectChars $selectService
     */
    public function __construct(ISelectChars $selectService, NormalizerInterface $normalizer)
    {
        $this->selectService = $selectService;
        $this->normalizer = $normalizer;
    }


    /**
     * @Route(
     *     "/characteristic/{uuid}",
     *     name="characteristics_single",
     *     methods={"GET"},
     *     requirements={"uuid": "[0-9a-f]{8}-[0-9a-f]{4}-[4][0-9a-f]{3}-[89ab][0-9a-f]{3}-[0-9a-f]{12}"}
     * )
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

    /**
     * @Route(
     *     "/characteristic/raw/{uuid}",
     *     name="characteristics_raw_single",
     *     methods={"GET"},
     *     requirements={"uuid": "[0-9a-f]{8}-[0-9a-f]{4}-[4][0-9a-f]{3}-[89ab][0-9a-f]{3}-[0-9a-f]{12}"}
     * )
     *
     * @param string $uuid has 404
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
     *     name="characteristics_raw_single",
     *     methods={"GET"}
     * )
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
