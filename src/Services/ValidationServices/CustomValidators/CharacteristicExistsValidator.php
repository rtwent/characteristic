<?php
declare(strict_types=1);


namespace App\Services\ValidationServices\CustomValidators;

use App\Entity\Characteristics;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

/**
 * Class ServiceExistsValidator
 * @package App\Services\ValidationServices\CustomValidators
 */
final class CharacteristicExistsValidator extends ConstraintValidator
{
    /**
     * @inheritDoc
     * @param mixed $value
     * @param Constraint $constraint instance of \App\Services\ValidationServices\CustomValidators\CharacteristicExists
     */
    public function validate($value, Constraint $constraint)
    {
        if (!$constraint instanceof CharacteristicExists) {
            throw new UnexpectedTypeException($constraint, CharacteristicExists::class);
        }

        if (null === $value || '' === $value) {
            return;
        }

        $characteristicEntity = $constraint->getEntityManager()
            ->getRepository(Characteristics::class)->find($value);

        if (\is_null($characteristicEntity)) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ charId }}', $value)->addViolation();
        }
    }
}