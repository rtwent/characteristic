<?php

namespace App\Entity;

use App\Collections\ValueOutCollection;
use App\Entity\ValueObjects\RepCharValuePropertiesVO;
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
     * Too complicated o(n2) difficult without using of DQL
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
        $repValuesUuidsSorted = [];
        foreach ($repValuesSorted as $key => $repValues) {
            $repValuesUuidsSorted[$key] = $repValues[RepCharValuesCollectionVO::SORT_FIELD];
        }

        $repValuesCollection = [];
        $allCharValues = $this->getCharacteristic()->getValues();
        $allCharValues->map(function (Values $allCharValue) use ($repValuesUuidsSorted, &$repValuesCollection) {
            if (isset($repValuesUuidsSorted[strval($allCharValue->getId())])) {
                $offset = $repValuesUuidsSorted[strval($allCharValue->getId())];
                $representationSpecific = new RepCharValuePropertiesVO($offset);
                $allCharValue->setRepresentationSpecific($representationSpecific);
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

    /**
     * @param Representation $representation
     */
    public function setRepresentation(Representation $representation): void
    {
        $this->representation = $representation;
    }

    /**
     * @param Characteristics $characteristic
     */
    public function setCharacteristic(Characteristics $characteristic): void
    {
        $this->characteristic = $characteristic;
    }

    /**
     * @param RepCharValuesCollectionVO $repCharValues
     */
    public function setRepCharValues(RepCharValuesCollectionVO $repCharValues): void
    {
        $this->repCharValues = $repCharValues;
    }

    /**
     * @param RepCharValueSettingsVO $settings
     */
    public function setSettings(RepCharValueSettingsVO $settings): void
    {
        $this->settings = $settings;
    }


}
