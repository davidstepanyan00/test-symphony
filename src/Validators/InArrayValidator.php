<?php

namespace App\Validators;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class InArrayValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint): void
    {
        if (!isset($value)) {
            return;
        }

        if (!in_array($value, $constraint->choices)) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ value }}', $value)
                ->addViolation();
        }
    }
}