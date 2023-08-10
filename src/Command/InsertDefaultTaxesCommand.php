<?php

namespace App\Command;

use App\Entity\Taxes;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class InsertDefaultTaxesCommand extends AbstractCommand
{
    public const COMMAND_NAME = 'insert:default-taxes';

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
        $data = $this->getTaxes();

        foreach ($data as $item) {
            $tax = new Taxes();

            $tax->setCountry($item['country']);
            $tax->setPercent($item['percent']);
            $tax->setCountryCode($item['country_code']);
            $tax->setCreatedAt(new DateTime());

            $this->entityManager->persist($tax);
        }

        $this->entityManager->flush();

        return 0;
    }


    private function getTaxes(): array
    {
        return [
            [
                'country' => 'Germany',
                'percent' => 19,
                'country_code' => 'DE',
            ],
            [
                'country' => 'Italy',
                'percent' => 22,
                'country_code' => 'IT',
            ],
            [
                'country' => 'France',
                'percent' => 20,
                'country_code' => 'FR',
            ],
            [
                'country' => 'Greece',
                'percent' => 24,
                'country_code' => 'GR',
            ],
        ];
    }
}