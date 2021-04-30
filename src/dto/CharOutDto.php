<?php
declare(strict_types=1);


namespace App\dto;


use Symfony\Component\Uid\Uuid;
use Symfony\Component\Serializer\Annotation\Groups;

final class CharOutDto
{
    /**
     * @Groups({"repCharValues"})
     */
    private Uuid $id;
    /**
     * @Groups({"repCharValues"})
     */
    private string $alias;
    /**
     * @Groups({"repCharValues"})
     */
    private string $type;
    /**
     * @Groups({"repCharValues"})
     */
    private string $label;
    /**
     * @Groups({"repCharValues"})
     */
    private string $short;

    private array $searchProps;

    /**
     * CharOutDto constructor.
     * @param Uuid $id
     * @param string $alias
     * @param string $type
     * @param string $label
     * @param string $short
     * @param array $searchProps
     */
    public function __construct(Uuid $id, string $alias, string $type, string $label, string $short, array $searchProps)
    {
        $this->id = $id;
        $this->alias = $alias;
        $this->type = $type;
        $this->label = $label;
        $this->short = $short;
        $this->searchProps = $searchProps;
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
    public function getAlias(): string
    {
        return $this->alias;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @return string
     */
    public function getLabel(): string
    {
        return $this->label;
    }

    /**
     * @return string
     */
    public function getShort(): string
    {
        return $this->short;
    }

    /**
     * @return array
     */
    public function getSearchProps(): array
    {
        return $this->searchProps;
    }


}