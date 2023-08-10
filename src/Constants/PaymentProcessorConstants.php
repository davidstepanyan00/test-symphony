<?php

namespace App\Constants;

class PaymentProcessorConstants
{
    public const PAYPAL = 'paypal';
    public const STRIPE = 'stripe';

    public const PROCESSORS = [
      self::PAYPAL,
      self::STRIPE,
    ];

    public const PENDING = 'pending';
    public const PAID = 'paid';
}