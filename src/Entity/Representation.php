<?php

namespace App\Entity;

use App\Repository\RepresentationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping\UniqueConstraint as UniqueConstraint;
use Doctrine\ORM\Mapping\Index as INDEX;
use Gedmo\Mapping\Annotation as Gedmo;
use DateTimeInterface;

/**
 * @ORM\Entity(repositoryClass=RepresentationRepository::class)
 * @ORM\Table(
 *     name="out_representation",
 *     indexes={
 *          @INDEX(name="rep_uuid", columns={"id"})
 *     },
 *     uniqueConstraints={
 *          @UniqueConstraint(name="id", columns={"id"})
 *     }
 *
 *
 * )
 * @Gedmo\SoftDeleteable(fieldName="deletedAt")
 */
class Representation
{
    /**
     * @ORM\Id
     * @ORM\Column(type="uuid", unique=true, name="id")
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private Uuid $id;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\RepresentationValues", mappedBy="representation", cascade={"persist", "remove"})
     */
    private Collection $repCharacteristics;

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
     * Representation constructor.
     */
    public function __construct()
    {
        $this->repCharacteristics = new ArrayCollection();
    }


    public function getId(): Uuid
    {
        return $this->id;
    }

    /**
     * @return Collection
     */
    public function getRepCharacteristics(): Collection
    {
        return $this->repCharacteristics;
    }


}
