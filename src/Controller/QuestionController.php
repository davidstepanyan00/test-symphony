<?php

namespace App\Controller;

use App\Actions\GetQuestionsAction;
use App\Actions\SubmitQuestionsAction;
use Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class QuestionController extends AbstractController
{
    /**
     * @throws Exception
     */
    #[Route('/', methods: ['GET'])]
    public function index(
        Request $request,
        GetQuestionsAction $action,
    ): Response {

        return $this->render('test.twig', ['questions' => $action->run()]);
    }

    /**
     * @throws Exception
     */
    #[Route('/submit', methods: ['POST'])]
    public function submit(
        Request $request,
        SubmitQuestionsAction $action,
    ): Response {
        $data = $request->request->all();

        return $this->render('result.twig', ['result' => $action->run($data)]);
    }
}