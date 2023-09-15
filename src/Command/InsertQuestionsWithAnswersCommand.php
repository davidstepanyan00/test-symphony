<?php

namespace App\Command;

use App\Entity\Answer;
use App\Entity\Question;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class InsertQuestionsWithAnswersCommand extends AbstractCommand
{
    public const COMMAND_NAME = 'insert:questions-with-answers';

    protected function configure(): void
    {
        $this->setName(self::COMMAND_NAME);
    }

    public function __construct(protected EntityManagerInterface $entityManager)
    {
        parent::__construct(self::COMMAND_NAME);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $data = $this->getData();

        foreach ($data as $item) {
            $question = new Question();
            $question->setDescription($item['description']);
            $this->entityManager->persist($question);

            foreach ($item['answers'] as $answerItem) {
                $answer = new Answer();

                $answer->setValue($answerItem['value']);
                $answer->setIsRight($answerItem['is_right']);
                $answer->setIndex($answerItem['index']);
                $answer->setQuestion($question);

                $this->entityManager->persist($answer);
            }

        }

        $this->entityManager->flush();

        return 0;
    }


    private function getData(): array
    {
        return [
            [
                'description' => '1 + 1 = ',
                'answers' => [
                  ['value' => '3', 'is_right' => false, 'index' => 1],
                  ['value' => '2', 'is_right' => true, 'index' => 2],
                  ['value' => '0', 'is_right' => false, 'index' => 3],
                ],
            ],
            [
                'description' => '2 + 2 = ',
                'answers' => [
                    ['value' => '4', 'is_right' => true, 'index' => 1],
                    ['value' => '3 + 1', 'is_right' => true, 'index' => 2],
                    ['value' => '10', 'is_right' => false, 'index' => 3],
                ],
            ],
            [
                'description' => '3 + 3 = ',
                'answers' => [
                    ['value' => '1 + 5', 'is_right' => true, 'index' => 1],
                    ['value' => '1', 'is_right' => false, 'index' => 2],
                    ['value' => '6', 'is_right' => true, 'index' => 3],
                    ['value' => '2 + 4', 'is_right' => true, 'index' => 4],
                ],
            ],
            [
                'description' => '4 + 4 = ',
                'answers' => [
                    ['value' => '8', 'is_right' => true, 'index' => 1],
                    ['value' => '4', 'is_right' => false, 'index' => 2],
                    ['value' => '0', 'is_right' => false, 'index' => 3],
                    ['value' => '0 + 8', 'is_right' => true, 'index' => 4],
                ],
            ],
            [
                'description' => '5 + 5 = ',
                'answers' => [
                    ['value' => '6', 'is_right' => false, 'index' => 1],
                    ['value' => '18', 'is_right' => false, 'index' => 2],
                    ['value' => '10', 'is_right' => true, 'index' => 3],
                    ['value' => '9', 'is_right' => false, 'index' => 4],
                    ['value' => '0', 'is_right' => false, 'index' => 5],
                ],
            ],
            [
                'description' => '6 + 6 = ',
                'answers' => [
                    ['value' => '3', 'is_right' => false, 'index' => 1],
                    ['value' => '9', 'is_right' => false, 'index' => 2],
                    ['value' => '0', 'is_right' => false, 'index' => 3],
                    ['value' => '12', 'is_right' => true, 'index' => 4],
                    ['value' => '5 + 7', 'is_right' => true, 'index' => 5],
                ],
            ],
            [
                'description' => '7 + 7 = ',
                'answers' => [
                    ['value' => '5', 'is_right' => false, 'index' => 1],
                    ['value' => '14', 'is_right' => true, 'index' => 2],
                ],
            ],
            [
                'description' => '8 + 8 = ',
                'answers' => [
                    ['value' => '16', 'is_right' => true, 'index' => 1],
                    ['value' => '12', 'is_right' => false, 'index' => 2],
                    ['value' => '9', 'is_right' => false, 'index' => 3],
                    ['value' => '5', 'is_right' => false, 'index' => 4],
                ],
            ],
            [
                'description' => '9 + 9 =  ',
                'answers' => [
                    ['value' => '18', 'is_right' => true, 'index' => 1],
                    ['value' => '9', 'is_right' => false, 'index' => 2],
                    ['value' => '17 + 1', 'is_right' => true, 'index' => 3],
                    ['value' => '2 + 16', 'is_right' => true, 'index' => 4],
                ],
            ],
            [
                'description' => '10 + 10 = ',
                'answers' => [
                    ['value' => '0', 'is_right' => false, 'index' => 1],
                    ['value' => '2', 'is_right' => false, 'index' => 2],
                    ['value' => '8', 'is_right' => false, 'index' => 3],
                    ['value' => '20', 'is_right' => true, 'index' => 4],
                ],
            ]
        ];
    }
}