<?php

namespace App\Classes;

use App\Constants\PaymentProcessorConstants;
use App\Entity\Transaction;
use App\PaymentProcessor\PaypalPaymentProcessor;
use App\PaymentProcessor\StripePaymentProcessor;
use Exception;

class HandleTransaction
{
    /**
     * @throws Exception
     */
    public function run(Transaction $transaction): void
    {
        switch ($transaction->getPaymentProcessor()) {
            case PaymentProcessorConstants::STRIPE:
                (new StripePaymentProcessor)->processPayment($transaction->getTotalPrice());
                break;
            case PaymentProcessorConstants::PAYPAL:
                (new PaypalPaymentProcessor())->pay($transaction->getTotalPrice());
                break;
        }
    }
}