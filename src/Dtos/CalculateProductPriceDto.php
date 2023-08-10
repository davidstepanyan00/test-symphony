<?php

namespace App\Dtos;

class CalculateProductPriceDto
{
    public int $product;
    public string $taxNumber;
    public ?string $couponCode = null;
    public string $paymentProcessor;
}