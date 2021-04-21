<?php
declare(strict_types=1);


namespace App\Services\Chars;


use App\dto\CharOutDto;
use App\dto\UpsertCharacteristic;
use App\Entity\Characteristics;
use App\Interfaces\Chars\IUpsertService;
use App\Repository\CharacteristicsRepository;
use Doctrine\ORM\EntityManagerInterface;

final class UpsertChars implements IUpsertService
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

    public function create(UpsertCharacteristic $characteristic): CharOutDto
    {
        return $this->entityManager->getRepository(Characteristics::class)
            ->create($characteristic);
    }


}