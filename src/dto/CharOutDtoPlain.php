<?php
declare(strict_types=1);


namespace App\dto;


use App\Collections\ValueOutCollection;
use Symfony\Component\Uid\Uuid;
use OpenApi\Annotations as OA;
use Nelmio\ApiDocBundle\Annotation\Model;
use Symfony\Component\Serializer\Annotation\SerializedName;
use Symfony\Component\Serializer\Annotation\Groups;

final class CharOutDtoPlain extends CharOutDto
{
    /**
     * @var ValueOutCollection
     *
     * @OA\Property(
     *     type="array",
     *     @OA\Items(
     *          ref=@Model(type=App\dto\ValueOutDto::class)
     *     )
     * )
     * @Groups({"char:item:read"})
     * @SerializedName("vocabulary")
     */
    private ValueOutCollection $values;

    /**
     * CharOutDto constructor.
     * @param Uuid $id
     * @param string $alias
     * @param string $type
     * @param string $label
     * @param string $short
     * @param array $searchProps
     * @param string|null $measurement
     * @param ValueOutCollection $values
     */
    public function __construct(Uuid $id, string $alias, string $type, string $label, string $short, array $searchProps, ?string $measurement, ValueOutCollection $values)
    {
        $this->id = $id;
        $this->alias = $alias;
        $this->type = $type;
        $this->label = $label;
        $this->short = $short;
        $this->searchProps = $searchProps;
        $this->measurement = $measurement;
        $this->values = $values;
    }

    /**
     * @return ValueOutCollection
     */
    public function getValues(): ValueOutCollection
    {
        return $this->values;
    }
}