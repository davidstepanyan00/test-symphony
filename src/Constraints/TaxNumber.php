<?php

namespace App\Constraints;

use App\Validators\TaxNumberValidator;
use Symfony\Component\Validator\Constraint;

class TaxNumber extends Constraint
{
    public string $message = 'Tax number is invalid!';

    public function validatedBy(): string
    {
        return TaxNumberValidator::class;
    }
}