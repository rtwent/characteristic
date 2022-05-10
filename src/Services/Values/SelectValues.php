<?php


namespace App\Services\Values;

use App\Collections\ValueOutCollection;
use App\dto\ValueOutDto;
use App\dto\ValueOutRawDto;
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
use Symfony\Contracts\Translation\TranslatorInterface;


final class SelectValues implements ISelectValues
{
    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $entityManager;

    private TranslatorInterface $translator;

    /**
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager, TranslatorInterface $translator)
    {
        $this->entityManager = $entityManager;
        $this->translator = $translator;
    }

    /**
     * @throws ValueObjectConstraint
     */
    public function singleChar(UuidVO $uuidVO): ValueOutDto
    {
        $entity = $this->entityManager->getRepository(Values::class)->findOrFail($uuidVO);
        return (new ValuesEntityMapper($entity))->toDto();
    }

    /**
     * @throws ValueObjectConstraint
     */
    public function singleRawChar(UuidVO $uuidVO): ValueOutRawDto
    {
        $entity = $this->entityManager->getRepository(Values::class)->findOrFail($uuidVO);
        return (new ValuesEntityMapper($entity))->toRawDto($this->translator);
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