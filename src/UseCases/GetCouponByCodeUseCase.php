<?php

namespace App\UseCases;

use App\Entity\Coupons;
use Doctrine\ORM\EntityManagerInterface;

class GetCouponByCodeUseCase
{
    public function __construct(
        protected EntityManagerInterface $entityManager
    ) {
    }

    public function run(string $couponCode): Coupons
    {
        $repository = $this->entityManager->getRepository(Coupons::class);

        return $repository->findOneBy(['code' => $couponCode]);
    }
}