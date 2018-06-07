<?php

namespace App\Form;

use App\Api\PbBundle\Model\PayPb;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Length;

class PayPbType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'id',
                TextType::class,
                [
                    'constraints' => [new NotBlank()],
                    'attr' => ['class' => 'form-control', 'size' => 20],
                    'label' => 'ID мерчанта'
                ]
            )
            ->add(
                'password',
                PasswordType::class,
                [
                    'constraints' => [new NotBlank()],
                    'attr' => ['class' => 'form-control', 'size' => 20],
                    'label' => 'Пароль'
                ]
            )
            ->add(
                'b_card_or_acc',
                TextType::class,
                [
                    'constraints' => [new NotBlank()],
                    'attr' => ['class' => 'form-control', 'size' => 32],
                    'label' => 'Карта или счёт получателя'
                ]
            )
            ->add(
                'amt',
                TextType::class,
                [
                    'constraints' => [new NotBlank()],
                    'attr' => ['class' => 'form-control', 'size' => 10],
                    'label' => 'Сумма Напр.: 23.05'
                ]
            )
            ->add(
                'ccy',
                ChoiceType::class,
                [
                    'constraints' => [new NotBlank()],
                    'choices' => [
                        'UAH' => 'UAH',
                        'EUR' => 'EUR',
                        'USD' => 'USD'
                    ],
                    'attr' => ['class' => 'form-control'],
                    'label' => 'Валюта'
                ]
            )
            ->add(
                'details',
                TextareaType::class,
                [
                    'constraints' => [],
                    'attr' => ['class' => 'form-control', 'cols' => 32, 'rows' => 3],
                    'label' => 'Назначение платежа'
                ]
            )
            ->add(
                'submit',
                SubmitType::class,
                [
                    'attr' => ['class' => 'form-control btn-primary pull-right'],
                    'label' => 'Выполнить'
                ]
            );
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => PayPb::class,
        ]);
    }

    public function getName(): string
    {
        return 'pay_pb_form';
    }
}
