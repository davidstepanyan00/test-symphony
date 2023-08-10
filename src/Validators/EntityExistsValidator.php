<?php

namespace App\Validators;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class EntityExistsValidator extends ConstraintValidator
{
    public function __construct(
        protected EntityManagerInterface $entityManager
    ) {
    }

    public function validate($value, Constraint $constraint): void
    {
        $repository = $this->entityManager->getRepository($constraint->repositoryClass);

        $entity = $repository->findOneBy([$constraint->field => $value]);

        if (!$entity) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ entity }}', $constraint->entity)
                ->addViolation();
        }
    }
}