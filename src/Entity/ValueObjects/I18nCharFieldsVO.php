<?php
declare(strict_types=1);

namespace App\Entity\ValueObjects;


use App\Exceptions\ValueObjectConstraint;
use App\Interfaces\ToArray;
use OpenApi\Annotations as OA;
use Nelmio\ApiDocBundle\Annotation\Model;

final class I18nCharFieldsVO extends BaseValueObject implements \JsonSerializable, ToArray
{
    /**
     * @OA\Property(
     *      description="Полное название характеристики",
     *      type="string"
     * )
     */
    private string $label;
    /**
     * @OA\Property(
     *      description="Короткое название характеристики",
     *      type="string"
     * )
     */
    private string $short;

    /**
     * I18NCharFieldsVO constructor.
     * @param string $label
     * @param string $short
     * @throws ValueObjectConstraint
     */
    public function __construct(string $label, string $short)
    {
        $this->label = $this->filterEmptyParam($label, 'Label');
        $this->short = $this->filterEmptyParam($short, 'Short description');
    }

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }

    public function toArray(): array
    {
        return ['label' => $this->label, 'short' => $this->short];
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


}