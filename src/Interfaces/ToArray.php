<?php


namespace App\Interfaces;

/**
 * Interface ToArray
 * Transform object into array
 * @package App\Controller\interfaces
 */
interface ToArray
{
    /**
     * Serializing object to array
     * @return array
     */
    public function toArray(): array;
}