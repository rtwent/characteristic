<?php
declare(strict_types=1);


namespace App\Services\Chars;


use App\dto\CharOutDto;
use App\dto\UpsertCharacteristic;
use App\Entity\Characteristics;
use App\Entity\ValueObjects\UuidVO;
use App\Interfaces\Chars\IUpsertService;
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

    public function update(UpsertCharacteristic $characteristic, UuidVO $uuidVo): CharOutDto
    {
        return $this->entityManager->getRepository(Characteristics::class)
            ->update($characteristic, $uuidVo);
    }

    public function delete(UuidVO $uuidVo): void
    {
        $this->entityManager->getRepository(Characteristics::class)
            ->remove($uuidVo);
    }


}