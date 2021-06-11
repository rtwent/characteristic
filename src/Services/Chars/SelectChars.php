<?php
declare(strict_types=1);


namespace App\Services\Chars;


use App\Collections\CharOutCollection;
use App\dto\CharFilter;
use App\dto\CharOutDto;
use App\dto\CharOutRawDto;
use App\Entity\Characteristics;
use App\Entity\ValueObjects\UuidVO;
use App\Exceptions\ValueObjectConstraint;
use App\Interfaces\ISelectChars;
use App\Mappers\CharacteristicEntityMapper;
use App\Repository\CharacteristicsRepository;
use App\Repository\Criterias\Chars\AliasCriteria;
use App\Repository\Criterias\CriteriasMerger;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\EntityManagerInterface;


final class SelectChars implements ISelectChars
{
    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $entityManager;

    private CharacteristicsRepository $characteristicRepo;

    /**
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->characteristicRepo = $this->entityManager->getRepository(Characteristics::class);
    }

    /**
     * @param CharFilter $dto
     * @return CharOutCollection
     * @throws ValueObjectConstraint
     */
    public function collection(CharFilter $dto): CharOutCollection
    {
        $criterias = new CriteriasMerger(Criteria::create());
        if (!empty($dto->getAliases())) {
            $criterias->add(new AliasCriteria($dto->getAliases()));
        }

        $results = $this->characteristicRepo->filter($dto, $criterias);

        $collection = new CharOutCollection();
        foreach ($results as $entity) {
            $dto = (new CharacteristicEntityMapper($entity))->toDto();
            $collection->append($dto);
        }

        return $collection;
    }

    /**
     * @param UuidVO $uuidVO
     * @return CharOutDto
     */
    public function singleChar(UuidVO $uuidVO): CharOutDto
    {
        /** @var Characteristics $entity */
        $entity = $this->characteristicRepo->findOrFail($uuidVO);
        return (new CharacteristicEntityMapper($entity))->toDto();
    }

    public function rawChar(UuidVO $uuidVO): CharOutRawDto
    {
        /** @var Characteristics $entity */
        $entity = $this->characteristicRep->findOrFail($uuidVO);

        return (new CharacteristicEntityMapper($entity))->toRawDto();
    }
}