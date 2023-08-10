<?php

namespace App\Actions;

use App\Classes\HandleTransaction;
use App\Constants\PaymentProcessorConstants;
use App\Entity\Transaction;
use App\Transformators\ErrorTransformator;
use App\Transformators\ResponseTransformator;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Throwable;

class PayPaymentAction
{
    public function __construct(
        protected EntityManagerInterface $entityManager,
        protected HandleTransaction $handleTransaction,
    ) {
    }

    /**
     * @throws Exception
     */
    public function run(string $transactionId): ErrorTransformator | ResponseTransformator
    {
        try {
            /**
             * @var Transaction $transaction
             */
            $transaction = $this->entityManager->getRepository(Transaction::class)
                ->findOneBy(['id' => $transactionId]);

            if (!$transaction) {
                throw new Exception();
            }

            $transaction->setStatus(PaymentProcessorConstants::PAID);

            $this->entityManager->persist($transaction);
            $this->entityManager->flush($transaction);

            $this->handleTransaction->run($transaction);

            return new ResponseTransformator(['status' => true]);
        } catch (Throwable $e) {
            return new ErrorTransformator($e);
        }
    }
}