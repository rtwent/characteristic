<?php


namespace App\Services\Values;

use App\Collections\ValueOutCollection;
use App\dto\ValueOutDto;
use App\Entity\ValueObjects\UuidVO;
use App\Entity\Values;
use App\Exceptions\ValueObjectConstraint;
use App\Interfaces\Values\ISelectValues;
use App\Mappers\ValuesEntityMapper;
use App\Repository\Criterias\CriteriasMerger;
use App\Repository\Criterias\Values\CharUuidCriteria;
use App\Repository\ValuesRepository;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Query\QueryException;


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

    /**
     * @param UuidVO $charId
     * @return ValueOutCollection
     * @throws ValueObjectConstraint
     * @throws QueryException
     */
    public function getValuesByChar(UuidVO $charId): ValueOutCollection
    {
        $criterias = new CriteriasMerger(Criteria::create());
        $criterias->add(new CharUuidCriteria($charId));
        /** @var ValuesRepository $repo */
        $repo = $this->entityManager->getRepository(Values::class);
        $values = $repo->filter($criterias);

        $vocabulary = new ValueOutCollection();
        foreach ($values as $value) {
            $vocabulary->append((new ValuesEntityMapper($value))->toDto());
        }

        return $vocabulary;
    }
}