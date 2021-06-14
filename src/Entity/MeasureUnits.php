<?php

namespace App\Entity;

use App\Entity\ValueObjects\I18nMeasureUnitsFieldsVO;
use App\Entity\ValueObjects\I18nMeasureUnitsVO;
use App\Interfaces\Validatable;
use App\Repository\MeasureUnitsRepository;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping\UniqueConstraint;

/**
 * @ORM\Entity(repositoryClass=App\Repository\MeasureUnitsRepository::class)
 * @ORM\Table(
 *     name="measure_units",
 *     uniqueConstraints={
 *          @UniqueConstraint(name="measure_units_si_unique", columns={"si_name"})
 *     }
 * )
 * @Gedmo\SoftDeleteable(fieldName="deletedAt")
 */
class MeasureUnits implements Validatable
{
    /**
     * @ORM\Column(type="integer", nullable=false)
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private int $id;

    /**
     * @ORM\Column(name="si_name", type="string", length=5)
     */
    private string $siName;

    /**
     * @ORM\Column(type="I18nMeasureUnitsDbType", options={"jsonb":true, "default":"{}"})
     */
    private I18nMeasureUnitsVO $i18n;

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

    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getSiName(): string
    {
        return $this->siName;
    }

    /**
     * @param string $siName
     */
    public function setSiName(string $siName): void
    {
        $this->siName = $siName;
    }

    /**
     * @return I18nMeasureUnitsVO
     */
    public function getI18n(): I18nMeasureUnitsVO
    {
        return $this->i18n;
    }

    /**
     * @param I18nMeasureUnitsVO $i18n
     */
    public function setI18n(I18nMeasureUnitsVO $i18n): void
    {
        $this->i18n = $i18n;
    }


}
