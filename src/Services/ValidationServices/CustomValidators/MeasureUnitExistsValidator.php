<?php
declare(strict_types=1);


namespace App\Services\ValidationServices\CustomValidators;

use App\Entity\Characteristics;
use App\Entity\MeasureUnits;
use App\Exceptions\WrongRequest;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

/**
 * Class ServiceExistsValidator
 * @package App\Services\ValidationServices\CustomValidators
 */
final class MeasureUnitExistsValidator extends ConstraintValidator
{
    /**
     * @inheritDoc
     * @param mixed $value
     * @param Constraint $constraint instance of \App\Services\ValidationServices\CustomValidators\v
     */
    public function validate($value, Constraint $constraint)
    {
        if (!$constraint instanceof MeasureUnitExists) {
            throw new UnexpectedTypeException($constraint, MeasureUnitExists::class);
        }

        if (null === $value || '' === $value) {
            return;
        }

        if(!is_numeric($value)) {
            throw new WrongRequest("Measure unit id must be integer");
        }

        $measureUnitEntity = $constraint->getEntityManager()
            ->getRepository(MeasureUnits::class)->find($value);

        if (\is_null($measureUnitEntity)) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ measureUnitId }}', strval($value))->addViolation();
        }
    }
}