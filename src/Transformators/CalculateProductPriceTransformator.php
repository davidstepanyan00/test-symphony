<?php

namespace App\Transformators;

use App\Entity\Transaction;

class CalculateProductPriceTransformator extends Transformator
{
    public function __construct(protected Transaction $transaction)
    {
    }

    public function data(): array
    {
        return [
            'id' => $this->transaction->getId(),
            'totalPrice' => $this->transaction->getTotalPrice(),
        ];
    }
}