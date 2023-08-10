<?php

namespace App\Controller;

use App\Actions\PayPaymentAction;
use Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class PayPaymentController extends AbstractController
{
    /**
     * @throws Exception
     */
    #[Route('/payment/pay/{transactionId}', requirements: ['transactionId' => '\d+'], methods: ['POST'])]
    public function payPayment(
        Request $request,
        PayPaymentAction $action,
    ): JsonResponse {
        $result = $action->run($request->get('transactionId'));

        return new JsonResponse($result->data());
    }
}