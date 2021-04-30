<?php

namespace App\Controller\v1;

use App\Entity\ValueObjects\RealtyTypeVO;
use App\Entity\ValueObjects\UuidVO;
use App\Exceptions\ValueObjectConstraint;
use App\Interfaces\Representations\ISelectRepresentation;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

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
     *     "/representation/allchars/{uuid}",
     *     name="representation_allchars_single",
     *     methods={"GET"},
     *     requirements={"uuid": "[0-9a-f]{8}-[0-9a-f]{4}-[4][0-9a-f]{3}-[89ab][0-9a-f]{3}-[0-9a-f]{12}"}
     * )
     *
     * @param string $uuid has 404
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
     *     "/representation/byrealtytype/{uuid}/{realtyType}",
     *     name="representation_allchars_by_realty_single",
     *     methods={"GET"},
     *     requirements={
     *      "uuid": "[0-9a-f]{8}-[0-9a-f]{4}-[4][0-9a-f]{3}-[89ab][0-9a-f]{3}-[0-9a-f]{12}",
     *      "realtytype": "[-a-z]+"
     *     }
     * )
     *
     * @param string $uuid has 404
     * @return Response
     * @throws ValueObjectConstraint
     * @throws ExceptionInterface
     */
    public function byRealtyType(string $uuid, string $realtyType): Response
    {
        $dto = $this->selectService->allCharsByRealtyType(new UuidVO($uuid), new RealtyTypeVO($realtyType));

        return new JsonResponse($this->normalizer->normalize($dto, null, ['groups' => 'repCharValues']));
    }


}
