<?php
declare(strict_types=1);


namespace App\dto;


final class CharFilter
{
    private array $aliases = [];
    private array $labels = [];

    /**
     * CharFilter constructor.
     * @param array $aliases
     * @param array $labels
     */
    public function __construct(array $aliases, array $labels)
    {
        $this->aliases = $aliases;
        $this->labels = $labels;
    }

    /**
     * @return array
     */
    public function getAliases(): array
    {
        return $this->aliases;
    }

    /**
     * @return array
     */
    public function getLabels(): array
    {
        return $this->labels;
    }


}