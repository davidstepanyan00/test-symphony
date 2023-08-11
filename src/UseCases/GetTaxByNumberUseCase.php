<?php

namespace App\UseCases;

use App\Entity\Tax;
use Doctrine\ORM\EntityManagerInterface;

class GetTaxByNumberUseCase
{
    public function __construct(
        protected EntityManagerInterface $entityManager
    ) {
    }

    public function run(string $taxNumber): Tax
    {
        $repository = $this->entityManager->getRepository(Tax::class);

        $code = substr($taxNumber,0,2);

        return $repository->findOneBy(['country_code' => $code]);
    }
}