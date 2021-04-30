<?php
declare(strict_types=1);


namespace App\Services\ValidationServices\CustomValidators;

use App\Entity\Characteristics;
use App\Entity\Representation;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

/**
 * Class RepresentationExistsValidator
 * @package App\Services\ValidationServices\CustomValidators
 */
final class RepresentationExistsValidator extends ConstraintValidator
{
    /**
     * @inheritDoc
     * @param mixed $value
     * @param Constraint $constraint instance of \App\Services\ValidationServices\CustomValidators\RepresentationExists
     */
    public function validate($value, Constraint $constraint)
    {
        if (!$constraint instanceof RepresentationExists) {
            throw new UnexpectedTypeException($constraint, RepresentationExists::class);
        }

        if (null === $value || '' === $value) {
            return;
        }

        $representationEntity = $constraint->getEntityManager()
            ->getRepository(Representation::class)->find($value);

        if (\is_null($representationEntity)) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ representationId }}', $value)->addViolation();
        }
    }
}