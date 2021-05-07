<?php
declare(strict_types=1);


namespace App\dto;


use App\Interfaces\ToArray;
use OpenApi\Annotations as OA;

/**
 * Class ErrorDto
 * @package App\dto
 */
final class ErrorDto implements ToArray
{
    /**
     * @OA\Property(
     *     type="boolean",
     *     description="Flag of success"
     * )
     */
    private bool $success = false;
    /**
     * @OA\Property(
     *     type="string",
     *     description="Text representation of exception"
     * )
     */
    private string $error;
    /**
     * @OA\Property(
     *     type="integer",
     *     description="Response status code"
     * )
     */
    private int $code;
    /**
     * @OA\Property(
     *     type="string",
     *     description="Stack trace of error"
     * )
     */
    private string $trace;

    /**
     * ErrorDto constructor.
     * @param string $error
     * @param int $code
     * @param string $trace
     */
    public function __construct(string $error, int $code, string $trace)
    {
        $this->error = $error;
        $this->code = $code;
        $this->trace = $trace;
    }

    /**
     * @return bool
     */
    public function isSuccess(): bool
    {
        return $this->success;
    }

    /**
     * @return string
     */
    public function getError(): string
    {
        return $this->error;
    }

    /**
     * @return int
     */
    public function getCode(): int
    {
        return $this->code;
    }

    /**
     * @return string
     */
    public function getTrace(): string
    {
        return $this->trace;
    }

    public function toArray(): array
    {
        return [
            'success' => $this->success,
            'error' => $this->error,
            'code' => $this->code,
            //'trace' => explode("\n", $event->getThrowable()->getTraceAsString())
            'trace' => $this->trace
        ];
    }


}