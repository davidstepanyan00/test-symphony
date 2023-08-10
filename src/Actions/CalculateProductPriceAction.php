<?php

namespace App\Actions;

use App\Constants\PaymentProcessorConstants;
use App\Dtos\CalculateProductPriceDto;
use App\Entity\Transaction;
use App\Transformators\CalculateProductPriceTransformator;
use App\Transformators\ErrorTransformator;
use App\UseCases\GetCouponByCodeUseCase;
use App\UseCases\GetProductByIdUseCase;
use App\UseCases\GetTaxByNumberUseCase;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Throwable;

class CalculateProductPriceAction
{
    protected CalculateProductPriceDto $dto;

    public function __construct(
        protected EntityManagerInterface $entityManager,
        protected GetProductByIdUseCase $getProductByIdUseCase,
        protected GetTaxByNumberUseCase $getTaxByNumberUseCase,
        protected GetCouponByCodeUseCase $getCouponByCodeUseCase,
    ) {
    }

    /**
     * @throws Exception
     */
    public function run(
        CalculateProductPriceDto $dto
    ): CalculateProductPriceTransformator | ErrorTransformator
    {
        $this->dto = $dto;

        try {
            $totalPrice = $this->calcTotalPrice();
            $transaction = $this->createTransaction($totalPrice);

            return new CalculateProductPriceTransformator($transaction);
        } catch (Throwable $e) {
            return new ErrorTransformator($e);
        }
    }


    private function createTransaction(float $totalPrice): Transaction
    {
        $dto = $this->dto;
        $transaction = new Transaction();

        $transaction->setProductId($dto->product);
        $transaction->setTaxNumber($dto->taxNumber);
        $transaction->setCouponCode($dto->couponCode);
        $transaction->setPaymentProcessor($dto->paymentProcessor);
        $transaction->setStatus(PaymentProcessorConstants::PENDING);
        $transaction->setTotalPrice($totalPrice);
        $transaction->setCreatedAt(new DateTime());

        $this->entityManager->persist($transaction);
        $this->entityManager->flush($transaction);

        return $transaction;
    }

    private function calcTotalPrice(): float
    {
        $dto = $this->dto;

        $product = $this->getProductByIdUseCase->run($dto->product);
        $tax = $this->getTaxByNumberUseCase->run($dto->taxNumber);
        $productPrice = $product->getPrice();
        $totalPercent = $tax->getPercent();


        if (isset($dto->couponCode)) {
            $coupon = $this->getCouponByCodeUseCase->run($dto->couponCode);
            $totalPercent -= $coupon->getPercent();
        }

        return $productPrice + ($productPrice * $totalPercent) / 100;
    }
}