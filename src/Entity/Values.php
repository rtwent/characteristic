<?php

namespace App\Entity;

use App\Entity\ValueObjects\I18nValuesVO;
use App\Entity\ValueObjects\RealtyTypesVO;
use App\Entity\ValueObjects\RepCharValuePropertiesVO;
use App\Interfaces\Validatable;
use App\Repository\ValuesRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;
use Symfony\Bridge\Doctrine\IdGenerator\UuidV4Generator;
use Gedmo\Mapping\Annotation as Gedmo;
use DateTimeInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping\UniqueConstraint as UniqueConstraint;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass=ValuesRepository::class)
 * @ORM\Table(
 *     name="values",
 *     uniqueConstraints={
 *      @UniqueConstraint(name="char_translation", columns={"fk_char", "i18n"})
 *     }
 * )
 *
 * @UniqueEntity(fields={"key", "defaultSort"})
 * @UniqueEntity(fields={"fkChar", "i18n"})
 *
 * @Gedmo\SoftDeleteable(fieldName="deletedAt")
 */
class Values implements Validatable
{
    /**
     * @ORM\Id
     * @ORM\Column(type="uuid", unique=true)
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class=UuidV4Generator::class)
     */
    private Uuid $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Characteristics", inversedBy="values")
     * @ORM\JoinColumn(name="fk_char", referencedColumnName="id", nullable=false)
     * @Assert\NotBlank()
     */
    private Characteristics $fkChar;

    /**
     * @ORM\Column(type="I18nCharValueDbType", options={"jsonb":true, "default":"{}"})
     */
    private I18nValuesVO $i18n;

    /**
     * @ORM\Column(type="integer", nullable=false)
     */
    private int $key;

    /**
     * @ORM\Column(type="integer", nullable=false, name="default_sort")
     */
    private int $defaultSort;

    /**
     * @ORM\Column(type="RealtyTypesDbType", name="only_type", options={"jsonb":true, "default":"[]"})
     */
    private RealtyTypesVO $onlyType;

    /**
     * @ORM\Column(type="JsonbForTrashDbType", name="service_config", options={"jsonb":true, "default":"[]"})
     */
    private array $serviceConfig;


    /**
     * @ORM\Column(type="datetime", name="created_at")
     * @Gedmo\Timestampable(on="create")
     */
    private ?DateTimeInterface $createdAt;

    /**
     * @ORM\Column(type="datetime", name="updated_at", nullable=true)
     * @Gedmo\Timestampable(on="update")
     */
    private ?DateTimeInterface $updatedAt;

    /**
     * @ORM\Column(type="datetime", name="deleted_at", nullable=true)
     */
    private ?DateTimeInterface $deletedAt;

    /**
     * @ORM\Column(type="integer", name="old_vector_id", nullable=true)
     */
    private int $oldVectorId;

    /**
     * @var RepCharValuePropertiesVO
     */
    private ?RepCharValuePropertiesVO $representationSpecific = null;

    /**
     * @return Uuid
     */
    public function getId(): Uuid
    {
        return $this->id;
    }

    /**
     * @return Characteristics
     */
    public function getFkChar(): Characteristics
    {
        return $this->fkChar;
    }

    /**
     * @return I18nValuesVO
     */
    public function getI18n(): I18nValuesVO
    {
        return $this->i18n;
    }

    /**
     * @return int
     */
    public function getKey(): int
    {
        return $this->key;
    }

    /**
     * @return int
     */
    public function getDefaultSort(): int
    {
        return $this->defaultSort;
    }

    /**
     * @return RealtyTypesVO
     */
    public function getOnlyType(): RealtyTypesVO
    {
        return $this->onlyType;
    }

    /**
     * @return array
     */
    public function getServiceConfig(): array
    {
        return $this->serviceConfig;
    }

    /**
     * @return RepCharValuePropertiesVO|null
     */
    public function getRepresentationSpecific(): ?RepCharValuePropertiesVO
    {
        return $this->representationSpecific;
    }

    /**
     * @param Characteristics $fkChar
     */
    public function setFkChar(Characteristics $fkChar): void
    {
        $this->fkChar = $fkChar;
    }

    /**
     * @param I18nValuesVO $i18n
     */
    public function setI18n(I18nValuesVO $i18n): void
    {
        $this->i18n = $i18n;
    }

    /**
     * @param int $key
     */
    public function setKey(int $key): void
    {
        $this->key = $key;
    }

    /**
     * @param int $defaultSort
     */
    public function setDefaultSort(int $defaultSort): void
    {
        $this->defaultSort = $defaultSort;
    }

    /**
     * @param RealtyTypesVO $onlyType
     */
    public function setOnlyType(RealtyTypesVO $onlyType): void
    {
        $this->onlyType = $onlyType;
    }

    /**
     * @param RepCharValuePropertiesVO|null $representationSpecific
     */
    public function setRepresentationSpecific(?RepCharValuePropertiesVO $representationSpecific): void
    {
        $this->representationSpecific = $representationSpecific;
    }


}
