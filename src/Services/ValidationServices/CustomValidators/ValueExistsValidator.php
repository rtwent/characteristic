<?php
declare(strict_types=1);


namespace App\Services\ValidationServices\CustomValidators;

use App\Entity\Characteristics;
use App\Entity\Representation;
use App\Entity\Values;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

/**
 * Class ValueExistsValidator
 * @package App\Services\ValidationServices\CustomValidators
 */
final class ValueExistsValidator extends ConstraintValidator
{
    /**
     * @inheritDoc
     * @param mixed $value
     * @param Constraint $constraint instance of \App\Services\ValidationServices\CustomValidators\ValueExists
     */
    public function validate($value, Constraint $constraint)
    {
        if (!$constraint instanceof ValueExists) {
            throw new UnexpectedTypeException($constraint, ValueExists::class);
        }

        if (null === $value || '' === $value) {
            return;
        }

        $valueEntity = $constraint->getEntityManager()
            ->getRepository(Values::class)->find($value);

        if (\is_null($valueEntity)) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ valueId }}', $value)->addViolation();
        }
    }
}