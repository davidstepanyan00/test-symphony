<?php

namespace App\Actions;

use App\Entity\Answer;
use App\Entity\TestResult;
use App\Repository\QuestionRepository;
use Doctrine\ORM\EntityManagerInterface;

class SubmitQuestionsAction
{
    public function __construct(
        protected QuestionRepository $questionRepository,
        protected EntityManagerInterface $entityManager,
    ) {
    }

    public function run(array $data): array
    {
        $questions = $this->questionRepository->getAllQuestionsWithAnswers();

        $wrongAnsweredQuestions = [];
        $rightAnsweredQuestions = [];

        foreach ($questions as $question) {
            $answers = $question->getAnswers()->toArray();

            if ($this->checkAnswerIsRight($answers, $data["answers{$question->getId()}"])) {
                $rightAnsweredQuestions[] = $question;
            } else {
                $wrongAnsweredQuestions[] = $question;
            }
        }

        $rightsCount = count($rightAnsweredQuestions);
        $wrongsCount = count($wrongAnsweredQuestions);

        $this->saveTestResult($wrongsCount, $rightsCount);

        return [
            "wrongAnsweredQuestions" => $wrongAnsweredQuestions,
            "rightAnsweredQuestions" => $rightAnsweredQuestions,
            "wrongsCount" => $wrongsCount,
            "rightsCount" => $rightsCount,
        ];
    }

    private function checkAnswerIsRight(array $answers, array $givenAnswers): bool
    {
        $filteredRightAnswers = [];

        foreach ($answers as $answer) {
            /**
             * @var  Answer $answer
             */
            if ($answer->isIsRight()) {
                $filteredRightAnswers[] = (int)$answer->getIndex();
            }
        }

        foreach ($givenAnswers as $givenAnswer) {
            if (!in_array($givenAnswer, $filteredRightAnswers)) {
                return false;
            }
        }

        return true;
    }

    private function saveTestResult(int $wrongsCount, int $rightsCount): void
    {
        $testResult = new TestResult();

        $testResult->setRightsCount($rightsCount);
        $testResult->setWrongsCount($wrongsCount);
        $testResult->setCreatedAt(new \DateTime());

        $this->entityManager->persist($testResult);

        $this->entityManager->flush();
    }
}