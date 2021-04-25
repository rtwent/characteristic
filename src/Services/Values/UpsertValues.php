<?php
declare(strict_types=1);


namespace App\Services\Values;


use App\dto\UpsertValue;
use App\dto\ValueOutDto;
use App\Entity\ValueObjects\UuidVO;
use App\Entity\Values;
use App\Interfaces\Values\IUpsertValues;
use Doctrine\ORM\EntityManagerInterface;

final class UpsertValues implements IUpsertValues
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

    public function create(UpsertValue $valuesDto): ValueOutDto
    {
        return $this->entityManager->getRepository(Values::class)
            ->create($valuesDto);
    }

    public function update(UpsertValue $valuesDto, UuidVO $uuidVO): ValueOutDto
    {
        return $this->entityManager->getRepository(Values::class)
            ->update($valuesDto, $uuidVO);
    }

    public function delete(UuidVO $uuidVO): void
    {
        $this->entityManager->getRepository(Values::class)
            ->remove($uuidVO);
    }

}