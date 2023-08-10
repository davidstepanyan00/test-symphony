<?php

namespace App\UseCases;

use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;

class GetProductByIdUseCase
{
   public function __construct(
       protected EntityManagerInterface $entityManager
   ) {
   }

   public function run(int $id): Product
   {
       $repository = $this->entityManager->getRepository(Product::class);

       return $repository->findOneBy(['id' => $id]);
   }
}