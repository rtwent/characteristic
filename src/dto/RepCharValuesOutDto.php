<?php
declare(strict_types=1);


namespace App\dto;


use Symfony\Component\Uid\Uuid;
use Symfony\Component\Serializer\Annotation\Groups;

final class RepCharValuesOutDto
{
    private int $id;
    private string $representationUuid;
    private CharWithValuesOutDto $characteristic;

}