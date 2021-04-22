<?php
declare(strict_types=1);


namespace App\dto;


final class Response202Dto
{
    private bool $success = true;

    /**
     * @return bool
     */
    public function isSuccess(): bool
    {
        return $this->success;
    }


}