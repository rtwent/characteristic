<?php


namespace App\Services\Values;

use App\dto\ValueOutDto;
use App\Entity\ValueObjects\UuidVO;
use App\Entity\Values;
use App\Interfaces\Values\ISelectValues;
use App\Mappers\ValuesEntityMapper;
use Doctrine\ORM\EntityManagerInterface;


final class SelectValues implements ISelectValues
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

    public function singleChar(UuidVO $uuidVO): ValueOutDto
    {
        $entity = $this->entityManager->getRepository(Values::class)->findOrFail($uuidVO);
        return (new ValuesEntityMapper($entity))->toDto();
    }
}