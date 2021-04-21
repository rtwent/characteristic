<?php
declare(strict_types=1);


namespace App\Exceptions;


use Symfony\Component\HttpFoundation\Response;

final class ValidationFail extends \Symfony\Component\HttpKernel\Exception\HttpException
{
    public function __construct(string $message = null, \Throwable $previous = null, array $headers = [], ?int $code = 0)
    {
        parent::__construct(Response::HTTP_UNPROCESSABLE_ENTITY, $message, $previous, $headers, Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function __toString()
    {
        parent::__toString();
    }
}