<?php
declare(strict_types=1);


namespace App\Services\Values;


use App\dto\UpsertValue;
use App\dto\ValueOutDto;
use App\Entity\ValueObjects\UuidVO;
use App\Entity\Values;
use App\Interfaces\Values\IUpsertValues;
use App\Repository\ValuesRepository;
use Doctrine\ORM\EntityManagerInterface;

final class UpsertValues implements IUpsertValues
{
    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $entityManager;
    private ValuesRepository $repo;

    /**
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repo = $this->entityManager->getRepository(Values::class);
    }

    public function create(UpsertValue $valuesDto): ValueOutDto
    {
        return $this->repo->create($valuesDto);
    }

    public function update(UpsertValue $valuesDto, UuidVO $uuidVO): ValueOutDto
    {
        return $this->repo->update($valuesDto, $uuidVO);
    }

    public function delete(UuidVO $uuidVO): void
    {
        $this->repo->remove($uuidVO);
    }

}