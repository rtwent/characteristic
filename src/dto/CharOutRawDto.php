<?php
declare(strict_types=1);


namespace App\dto;


use Symfony\Component\Uid\Uuid;

final class CharOutRawDto
{
    private Uuid $id;
    private string $alias;
    private string $type;
    private array $i18n;
    private array $searchProps;

    /**
     * CharOutDto constructor.
     * @param Uuid $id
     * @param string $alias
     * @param string $type
     * @param array $searchProps
     */
    public function __construct(Uuid $id, string $alias, string $type, array $searchProps, array $i18n)
    {
        $this->id = $id;
        $this->alias = $alias;
        $this->type = $type;
        $this->searchProps = $searchProps;
        $this->i18n = $i18n;
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
     * @return array
     */
    public function getI18n(): array
    {
        return $this->i18n;
    }

    /**
     * @return array
     */
    public function getSearchProps(): array
    {
        return $this->searchProps;
    }


}