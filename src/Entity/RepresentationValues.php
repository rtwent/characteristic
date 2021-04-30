<?php

namespace App\Entity;

use App\Collections\ValueOutCollection;
use App\Entity\ValueObjects\RepCharValuesCollectionVO;
use App\Entity\ValueObjects\RepCharValueSettingsVO;
use App\Entity\ValueObjects\RepCharValuesVO;
use App\Exceptions\InvalidDbValue;
use App\Mappers\ValuesEntityMapper;
use App\Repository\RepresentationValuesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=RepresentationValuesRepository::class)
 */
class RepresentationValues
{
    /**
     * @ORM\Id
     * @ORM\SequenceGenerator(sequenceName="representationvalue_sequence", initialValue=1)
     * @ORM\Column(type="integer", nullable=false, options={"default"="nextval('representationvalue_sequence'::regclass)"})
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private int $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Representation", inversedBy="repCharacteristics")
     * @ORM\JoinColumn(name="fk_rep_uuid", referencedColumnName="id", nullable=false)
     */
    private Representation $representation;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Characteristics", inversedBy="representationChars")
     * @ORM\JoinColumn(name="fk_characteristic", referencedColumnName="id", nullable=false)
     */
    private Characteristics $characteristic;

    /**
     * @ORM\Column(type="RepCharValuesCollectionDbType", options={"jsonb":true, "default":"{}"})
     */
    private RepCharValuesCollectionVO $repCharValues;

    /**
     * @ORM\Column(type="RepCharValuesSettingsDbType", options={"jsonb":true, "default":"{}"})
     */
    private RepCharValueSettingsVO $settings;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return Representation
     */
    public function getRepresentation(): Representation
    {
        return $this->representation;
    }

    /**
     * @return Characteristics
     */
    public function getCharacteristic(): Characteristics
    {
        return $this->characteristic;
    }

    /**
     * @return RepCharValuesCollectionVO
     */
    public function getRepCharValues(): RepCharValuesCollectionVO
    {
        return $this->repCharValues;
    }

    /**
     * Too complicated o(n2) difficult. Use it with DQL
     * @return ArrayCollection
     * @throws InvalidDbValue
     */
    public function getCharacteristicValues(): ArrayCollection
    {
        $repCharValuesCollection = $this->getRepCharValues();
        if (empty($repCharValuesCollection->getCharValues())) {
            throw new InvalidDbValue(sprintf(
                    "Can not find characteristic values for representation %s", $this->getRepresentation()->getId())
            );
        }

        $repValuesSorted = $repCharValuesCollection->toArray();
        uksort($repValuesSorted,
            // $a is a uuid of characteristic value
            fn(string $a, string $b) => $repValuesSorted[$a][RepCharValuesCollectionVO::SORT_FIELD] <=> $repValuesSorted[$b][RepCharValuesCollectionVO::SORT_FIELD]
        );
        $repValuesUuidsSorted = array_flip(array_keys($repValuesSorted));

        $repValuesCollection = [];
        $allCharValues = $this->getCharacteristic()->getValues();
        $allCharValues->map(function (Values $allCharValue) use ($repValuesUuidsSorted, &$repValuesCollection) {
            if (isset($repValuesUuidsSorted[strval($allCharValue->getId())])) {
                $offset = $repValuesUuidsSorted[strval($allCharValue->getId())];
                $repValuesCollection[$offset] = $allCharValue;
            }
        });

        ksort($repValuesCollection);

        return new ArrayCollection($repValuesCollection);
    }

    /**
     * @return RepCharValueSettingsVO
     */
    public function getSettings(): RepCharValueSettingsVO
    {
        return $this->settings;
    }


}
