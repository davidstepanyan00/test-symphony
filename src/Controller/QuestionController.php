<?php

namespace App\Controller;

use App\Actions\GetQuestionsAction;
use Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class QuestionController extends AbstractController
{
    /**
     * @throws Exception
     */
    #[Route('/questions', methods: ['GET'])]
    public function index(
        Request $request,
        GetQuestionsAction $action,
    ): Response {

        return $this->render('test.twig', ['questions' => $action->run()]);;
    }
}