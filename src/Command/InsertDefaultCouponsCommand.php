<?php

namespace App\Command;

use App\Entity\Coupon;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class InsertDefaultCouponsCommand extends AbstractCommand
{
    public const COMMAND_NAME = 'insert:default-coupons';

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
        $data = $this->getCoupons();

        foreach ($data as $item) {
            $coupon = new Coupon();

            $coupon->setPercent($item['percent']);
            $coupon->setDescription($item['description']);
            $coupon->setCreatedAt(new DateTime());
            $coupon->setCode($item['code']);

            $this->entityManager->persist($coupon);

        }

        $this->entityManager->flush();

        return 0;
    }


    private function getCoupons(): array
    {
        return [
            [
                'description' => 'Фиксированная сумма скидки',
                'percent' => 5,
                'code' => 'D15',
            ],
            [
                'description' => 'Процент от суммы покупки',
                'percent' => 6,
                'code' => 'F15',
            ],
        ];
    }
}