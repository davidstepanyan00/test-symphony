<?php

namespace App\Actions;

use App\Repository\QuestionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Exception;

class GetQuestionsAction
{
    public function __construct(
        protected QuestionRepository $questionRepository,
    ) {
    }

    /**
     * @throws Exception
     */
    public function run(): array
    {
        $questions = $this->questionRepository->getAllQuestionsWithAnswers();

        shuffle($questions);

        foreach ($questions as $question) {
            $answers = $question->getAnswers()->toArray();
            shuffle($answers);
            $question->setAnswers(new ArrayCollection($answers));
        }

        return $questions;
    }
}