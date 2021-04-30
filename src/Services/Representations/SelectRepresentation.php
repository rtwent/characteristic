<?php
declare(strict_types=1);


namespace App\Services\Representations;

use App\Collections\CharWithValuesOutCollection;
use App\Collections\ValueOutCollection;
use App\dto\CharWithValuesOutDto;
use App\Entity\Representation;
use App\Entity\RepresentationValues;
use App\Entity\ValueObjects\RealtyTypeVO;
use App\Entity\ValueObjects\UuidVO;
use App\Exceptions\InvalidDbValue;
use App\Exceptions\ValueObjectConstraint;
use App\Interfaces\Representations\ISelectRepresentation;
use App\Mappers\CharacteristicEntityMapper;
use App\Mappers\ValuesEntityMapper;
use Doctrine\ORM\EntityManagerInterface;


final class SelectRepresentation implements ISelectRepresentation
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

    /**
     * @param UuidVO $uuidVO
     * @param RealtyTypeVO $realtyTypeVO
     * @return CharWithValuesOutCollection
     * @throws InvalidDbValue
     * @throws ValueObjectConstraint
     */
    public function allCharsByRealtyType(UuidVO $uuidVO, RealtyTypeVO $realtyTypeVO): CharWithValuesOutCollection
    {
        $representation = $this->entityManager
            ->getRepository(Representation::class)
            ->repCharValuesByRealtyType($uuidVO, $realtyTypeVO);

        return $this->getCharWithValuesCollection($representation);
    }

    /**
     * @param UuidVO $uuidVO
     * @return CharWithValuesOutCollection
     * @throws InvalidDbValue
     * @throws ValueObjectConstraint
     */
    public function allChars(UuidVO $uuidVO): CharWithValuesOutCollection
    {
        /** @var Representation $representation */
        $representation = $this->entityManager->getRepository(Representation::class)
            ->repCharValues($uuidVO);

        return $this->getCharWithValuesCollection($representation);
    }

    /**
     * @param Representation $representation
     * @return CharWithValuesOutCollection
     * @throws InvalidDbValue
     * @throws ValueObjectConstraint
     */
    private function getCharWithValuesCollection(Representation $representation): CharWithValuesOutCollection
    {
        $charWithValues = new CharWithValuesOutCollection();

        foreach ($representation->getRepCharacteristics() as $repCharacteristic) {

            /** @var RepresentationValues $repCharacteristic */
            $charOutDto = (new CharacteristicEntityMapper($repCharacteristic->getCharacteristic()))->toDto();
            $valueOutCollection = new ValueOutCollection();

            $values = $repCharacteristic->getCharacteristicValues();
            foreach ($values as $key => $value) {
                $valueOutCollection->append((new ValuesEntityMapper($value))->toDto());
            }

            $charWithValues->append(new CharWithValuesOutDto($charOutDto, $valueOutCollection));
        }

        return $charWithValues;
    }

}