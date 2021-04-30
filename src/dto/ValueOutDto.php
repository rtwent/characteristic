<?php
declare(strict_types=1);


namespace App\dto;


use Symfony\Component\Uid\Uuid;
use Symfony\Component\Serializer\Annotation\Groups;

final class ValueOutDto
{
    /**
     * @Groups({"repCharValues"})
     */
    private Uuid $id;
    /**
     * @Groups({"repCharValues"})
     */
    private string $label;

    /**
     * @deprecated field must be removed
     * @var int
     */
    private int $key;

    private int  $defaultSort;
    /**
     * @Groups({"repCharValues"})
     */
    private array $onlyType;

    private CharOutDto $char;

    /**
     * ValueOutDto constructor.
     * @param Uuid $id
     * @param string $label
     * @param int $key
     * @param int $defaultSort
     * @param array $onlyType
     * @param CharOutDto $char
     */
    public function __construct(Uuid $id, string $label, int $key, int $defaultSort, array $onlyType, CharOutDto $char)
    {
        $this->id = $id;
        $this->label = $label;
        $this->key = $key;
        $this->defaultSort = $defaultSort;
        $this->onlyType = $onlyType;
        $this->char = $char;
    }

    /**
     * @return Uuid
     */
    public function getId(): Uuid
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getLabel(): string
    {
        return $this->label;
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
     * @return array
     */
    public function getOnlyType(): array
    {
        return $this->onlyType;
    }

    /**
     * @return CharOutDto
     */
    public function getChar(): CharOutDto
    {
        return $this->char;
    }


}