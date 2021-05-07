<?php
declare(strict_types=1);


namespace App\Services\Chars;


use App\dto\CharOutDto;
use App\dto\UpsertCharacteristic;
use App\Entity\Characteristics;
use App\Entity\ValueObjects\UuidVO;
use App\Interfaces\Chars\IUpsertService;
use App\Repository\CharacteristicsRepository;
use Doctrine\ORM\EntityManagerInterface;

final class UpsertChars implements IUpsertService
{
    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $entityManager;

    private CharacteristicsRepository $repo;

    /**
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repo = $this->entityManager->getRepository(Characteristics::class);
    }

    public function create(UpsertCharacteristic $characteristic): CharOutDto
    {
        return $this->repo->create($characteristic);
    }

    public function update(UpsertCharacteristic $characteristic, UuidVO $uuidVo): CharOutDto
    {
        return $this->repo->update($characteristic, $uuidVo);
    }

    public function delete(UuidVO $uuidVo): void
    {
        $this->repo->remove($uuidVo);
    }


}