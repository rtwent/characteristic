<?php

namespace App\Controller\v1;

use App\dto\CharFilter;
use App\Entity\ValueObjects\UuidVO;
use App\Exceptions\ValueObjectConstraint;
use App\Interfaces\ISelectChars;
use App\Interfaces\Values\ISelectValues;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

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
