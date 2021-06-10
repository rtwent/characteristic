<?php

namespace App\Entity;

use App\Entity\ValueObjects\I18nMeasureUnitsFieldsVO;
use App\Interfaces\Validatable;
use App\Repository\MeasureUnitsRepository;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping\UniqueConstraint;

/**
 * @ORM\Entity(repositoryClass=MeasureUnitsRepository::class)
 * @ORM\Table(
 *     name="measure_units",
 *     uniqueConstraints={
 *      @UniqueConstraint(name="measure_units_unique_id", columns={"id"})
 *     }
 * )
 */
class MeasureUnits implements Validatable
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\Column(name="si_name", type="string", length=5)
     */
    private string $siName;

    /**
     * @ORM\Column(type="I18nMeasureUnitsDbType", options={"jsonb":true, "default":"{}"})
     */
    private I18nMeasureUnitsFieldsVO $i18n;

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
     * @return I18nMeasureUnitsFieldsVO
     */
    public function getI18n(): I18nMeasureUnitsFieldsVO
    {
        return $this->i18n;
    }

    /**
     * @param I18nMeasureUnitsFieldsVO $i18n
     */
    public function setI18n(I18nMeasureUnitsFieldsVO $i18n): void
    {
        $this->i18n = $i18n;
    }


}
