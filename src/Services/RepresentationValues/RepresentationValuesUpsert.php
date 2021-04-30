<?php
declare(strict_types=1);


namespace App\Services\RepresentationValues;

use App\dto\RepCharValuesOutDto;
use App\dto\UpsertCharValuesDto;
use App\Entity\RepresentationValues;
use App\Interfaces\RepresentationValues\IRepresentationValues;
use Doctrine\ORM\EntityManagerInterface;


final class RepresentationValuesUpsert implements IRepresentationValues
{
    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $entityManager;

    /**
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function create(UpsertCharValuesDto $dto): RepCharValuesOutDto
    {
        return $this->entityManager
            ->getRepository(RepresentationValues::class)->create($dto);
    }
}