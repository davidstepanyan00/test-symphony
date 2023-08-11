<?php

namespace App\Validators;

use App\Entity\Tax;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class TaxNumberValidator extends ConstraintValidator
{
    public const FR = 'FR';

    public function __construct(
        protected EntityManagerInterface $entityManager
    ) {
    }

    public function validate($value, Constraint $constraint): void
    {
        $repository = $this->entityManager->getRepository(Tax::class);

        $countryCode = substr($value, 0, 2);

        $entity = $repository->findOneBy(['country_code' => $countryCode]);

        if (!$entity) {
            $this->context->buildViolation($constraint->message)
                ->addViolation();
            return;
        }

        if ($countryCode ===  self::FR) {
            $partLetters = substr($value, 2, 2);

            if (!preg_match('/^[A-Za-z]+$/', $partLetters)) {
                 $this->context->buildViolation($constraint->message)
                     ->addViolation();;
                 return;
            }

            $partNumbers = substr($value, 4);
        } else {
            $partNumbers = substr($value, 2);
        }

        if (!preg_match('/^[0-9]+$/', $partNumbers)) {
            $this->context->buildViolation($constraint->message)
                ->addViolation();
        }
    }
}