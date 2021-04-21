<?php

namespace App\Entity;

use App\Entity\ValueObjects\I18nCharVO;
use App\Entity\ValueObjects\SearchPropertyVO;
use App\Enum\CharsTypeEnum;
use App\Repository\CharacteristicsRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Index as INDEX;
use Doctrine\ORM\Mapping\UniqueConstraint as UniqueConstraint;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Bridge\Doctrine\IdGenerator\UuidV4Generator;
use DateTimeInterface;

/**
 * @ORM\Entity(repositoryClass=App\Repository\CharacteristicsRepository::class)
 * @ORM\Table(
 *     name="characteristics",
 *     uniqueConstraints={@UniqueConstraint(name="char_unique_alias", columns={"alias"})}
 * )
 * @Gedmo\SoftDeleteable(fieldName="deletedAt")
 */
class Characteristics
{
    /**
     * @ORM\Id
     * @ORM\Column(type="uuid", unique=true)
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class=UuidV4Generator::class)
     */
    private string $id;

    /**
     * @ORM\Column(type="string", unique=true, length=50, unique=true)
     */
    private string $alias;

    /**
     * @ORM\Column(type="I18nCharDbType", options={"jsonb":true, "default":"{}"})
     */
    private I18nCharVO $i18n;

    /**
     * @ORM\Column(type="CharSearchPropertyType")
     */
    private SearchPropertyVO $property;

    /**
     * @ORM\Column(type="CharType")
     */
    private CharsTypeEnum $type;

    /**
     * @ORM\Column(name="old_vector_id", nullable=true)
     */
    private int $oldVectorId;

    /**
     * @ORM\Column(name="old_form_builder", options={"jsonb": true, "default" : "{}"})
     */
    private $oldFormBuilder;

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
     * @param string $alias
     */
    public function setAlias(string $alias): void
    {
        $this->alias = $alias;
    }

    /**
     * @param I18nCharVO $i18n
     */
    public function setI18n(I18nCharVO $i18n): void
    {
        $this->i18n = $i18n;
    }

    /**
     * @param SearchPropertyVO $property
     */
    public function setProperty(SearchPropertyVO $property): void
    {
        $this->property = $property;
    }

    /**
     * @param CharsTypeEnum $type
     */
    public function setType(CharsTypeEnum $type): void
    {
        $this->type = $type;
    }

    public function getId(): string
    {
        return $this->id;
    }


}
