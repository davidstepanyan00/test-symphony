<?php

namespace App\UseCases;

use App\Entity\Coupon;
use Doctrine\ORM\EntityManagerInterface;

class GetCouponByCodeUseCase
{
    public function __construct(
        protected EntityManagerInterface $entityManager
    ) {
    }

    public function run(string $couponCode): Coupon
    {
        $repository = $this->entityManager->getRepository(Coupon::class);

        return $repository->findOneBy(['code' => $couponCode]);
    }
}