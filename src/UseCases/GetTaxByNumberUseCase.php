<?php

namespace App\UseCases;

use App\Entity\Taxes;
use Doctrine\ORM\EntityManagerInterface;

class GetTaxByNumberUseCase
{
    public function __construct(
        protected EntityManagerInterface $entityManager
    ) {
    }

    public function run(string $taxNumber): Taxes
    {
        $repository = $this->entityManager->getRepository(Taxes::class);

        $code = substr($taxNumber,0,2);

        return $repository->findOneBy(['country_code' => $code]);
    }
}