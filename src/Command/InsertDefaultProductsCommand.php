<?php

namespace App\Command;

use App\Entity\Product;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class InsertDefaultProductsCommand extends AbstractCommand
{
    public const COMMAND_NAME = 'insert:default-products';

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
        $data = $this->getProducts();

        foreach ($data as $item) {
            $product = new Product();
            $product->setName($item['name']);
            $product->setPrice($item['price']);
            $product->setCreatedAt(new DateTime());
            $this->entityManager->persist($product);

        }

        $this->entityManager->flush();

        return 0;
    }


    private function getProducts(): array
    {
        return [
            [
                'name' => 'iPhone',
                'price' => 100,
            ],

            [
                'name' => 'Headphones',
                'price' => 20,
            ],

            [
                'name' => 'Cover',
                'price' => 10,
            ],

        ];
    }
}