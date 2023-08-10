<?php

namespace App\Constraints;

use App\Validators\EntityExistsValidator;
use Symfony\Component\Validator\Constraint;

class EntityExists extends Constraint
{
    public string $message = 'The "{{ entity }}" does not exist in the database with that value.';
    public string $repositoryClass;
    public string $field;
    public string $entity;

    public function validatedBy(): string
    {
        return EntityExistsValidator::class;
    }
}