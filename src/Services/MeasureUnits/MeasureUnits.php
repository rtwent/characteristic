<?php
declare(strict_types=1);


namespace App\Services\MeasureUnits;


use App\Collections\MeasureUnitOutCollection;
use App\dto\MeasureUnitOutDto;
use App\dto\MeasureUnitRawOutDto;
use App\dto\UpsertMeasureUnit;
use App\Interfaces\MeasureUnits\IUnitsService;
use App\Mappers\MeasureUnitEntityMapper;
use App\Repository\MeasureUnitsRepository;
use Doctrine\ORM\EntityManagerInterface;

final class MeasureUnits implements IUnitsService
{
    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $entityManager;

    /**
     * @var MeasureUnitsRepository
     */
    private MeasureUnitsRepository $repo;

    /**
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repo = $this->entityManager->getRepository(\App\Entity\MeasureUnits::class);
    }

    public function collection(): MeasureUnitOutCollection
    {
        $results = $this->repo->findAll();
        $collection = new MeasureUnitOutCollection();

        foreach ($results as $entity) {
            $dto = (new MeasureUnitEntityMapper($entity))->toDto();
            $collection->append($dto);
        }

        return $collection;
    }

    public function raw(int $id): MeasureUnitRawOutDto
    {
        $entity = $this->repo->find($id);
        return (new MeasureUnitEntityMapper($entity))->toRawDto();
    }

    public function create(UpsertMeasureUnit $dto): MeasureUnitOutDto
    {
        return $this->repo->create($dto);
    }

    public function update(int $id, UpsertMeasureUnit $dto): MeasureUnitOutDto
    {
        return $this->repo->update($id, $dto);
    }

    public function delete(int $id): void
    {
        $this->repo->remove($id);
    }
}