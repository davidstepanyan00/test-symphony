<?php

namespace App\Constraints;

use App\Validators\InArrayValidator;
use Symfony\Component\Validator\Constraint;

class InArray extends Constraint
{
    public string $message = 'The value "{{ value }}" is not a valid choice.';
    public array $choices = [];

    public function validatedBy(): string
    {
        return InArrayValidator::class;
    }
}
