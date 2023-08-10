<?php

namespace App\Constraints;

use App\Validators\CouponCodeValidator;
use Symfony\Component\Validator\Constraint;

class CouponCode extends Constraint
{
    public string $message = 'The coupon code is invalid.';

    public function validatedBy(): string
    {
        return CouponCodeValidator::class;
    }
}