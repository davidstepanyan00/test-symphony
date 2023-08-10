<?php

namespace App\Validators;

use App\Entity\Coupons;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class CouponCodeValidator extends ConstraintValidator
{
    public function __construct(
        protected EntityManagerInterface $entityManager
    ) {
    }

    public function validate($value, Constraint $constraint): void
    {
        if (isset($value)) {
            $repository = $this->entityManager->getRepository(Coupons::class);

            $entity = $repository->findOneBy(['code' => $value]);

            if (!$entity) {
                $this->context->buildViolation($constraint->message)
                    ->addViolation();
            }
        }
    }
}