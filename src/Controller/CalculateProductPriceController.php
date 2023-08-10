<?php

namespace App\Controller;

use App\Actions\CalculateProductPriceAction;
use App\Dtos\CalculateProductPriceDto;
use App\Forms\CalcProductPriceForm;
use Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CalculateProductPriceController extends AbstractController
{
    /**
     * @throws Exception
     */
    #[Route('/product/calcPrice', methods: ['POST'])]
    public function calcPrice(
        Request $request,
        CalculateProductPriceAction $action,
    ): JsonResponse
    {
        $dto = new CalculateProductPriceDto();

        $requestData = json_decode($request->getContent(), true);
        $form = $this->createForm(CalcProductPriceForm::class, $dto);

        $form->submit($requestData);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $result = $action->run($dto);

            return new JsonResponse(['result' => $result->data()]);
        }

        return new JsonResponse(['errors' => $this->getFormErrors($form)], Response::HTTP_BAD_REQUEST);
    }
}