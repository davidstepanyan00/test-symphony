<?php

namespace App\Forms;

use App\Constants\PaymentProcessorConstants;
use App\Constraints\CouponCode;
use App\Constraints\EntityExists;
use App\Constraints\InArray;
use App\Constraints\TaxNumber;
use App\Dtos\CalculateProductPriceDto;
use App\Entity\Product;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;

class CalcProductPriceForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('product', TextType::class, [
                'constraints' => [
                    new NotBlank(['message' => 'The product field cannot be blank.']),
                    new EntityExists([
                        'repositoryClass' => Product::class,
                        'field' => 'id',
                        'entity' => 'product',
                    ]),
                ],
            ])
            ->add('taxNumber', TextType::class, [
                'constraints' => [
                    new NotBlank(['message' => 'The taxNumber field cannot be blank.']),
                    new TaxNumber()
                ],
         ])
            ->add('couponCode', TextType::class, [
                'constraints' => [
                    new CouponCode()
                ],
            ])
        ->add('paymentProcessor', TextType::class, [
            'constraints' => [
                new NotBlank(['message' => 'The paymentProcessor field cannot be blank.']),
                new InArray(['choices' => PaymentProcessorConstants::PROCESSORS])
            ],
        ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => CalculateProductPriceDto::class,
        ]);
    }
}