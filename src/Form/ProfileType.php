<?php

namespace App\Form;

use App\Entity\Profile;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Length;

class ProfileType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'title',
                TextType::class,
                [
                    'constraints' => [new NotBlank()],
                    'attr' => ['class' => 'form-control'],
                    'label' => 'Название'
                ]
            )
            ->add(
                'login',
                TextType::class,
                [
                    'constraints' => [new NotBlank()],
                    'attr' => ['class' => 'form-control', 'size' => 32],
                    'label' => 'Имя пользователя'
                ]
            )
            ->add(
                'key',
                TextType::class,
                [
                    'constraints' => [new NotBlank(), new Length(32)],
                    'attr' => ['class' => 'form-control', 'size' => 32],
                    'label' => 'Ключ'
                ]
            )
            ->add(
                'secret',
                TextType::class,
                [
                    'constraints' => [new NotBlank(), new Length(64)],
                    'attr' => ['class' => 'form-control', 'size' => '64'],
                    'label' => 'Секрет'
                ]
            )
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Profile::class,
        ]);
    }

    public function getName(): string
    {
        return 'profile_form';
    }
}
