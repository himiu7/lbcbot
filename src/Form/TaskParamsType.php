<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Tests\Extension\Core\Type\ChoiceTypeTest;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints\NotBlank;
use App\Document\AdTradeInput;
use App\Entity\Algorithm;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class TaskParamsType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $alg = $options['algorithm'];
        // $builder->add(field, type, opts)
        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) use ($builder, $alg) {
            /** @var TaskParamsType $form */
            $form = $event->getForm();

            if ($alg) {
                /** @var AlgorithmParam $param */
                foreach ($alg->getParams() as $param) {
                    // todo Refactore to exclude params
                    if ($param->getName() == 'ad_id') {
                        continue;
                    }
                    if ($param->getName() == 'price_step') {
                        $form->add(
                            $param->getName(),
                            ChoiceType::class,
                            [
                                'choices' => [
                                    '0.001' => '0.001',
                                    '0.002' => '0.002',
                                    '0.005' => '0.005',
                                    '0.008' => '0.008',
                                    '0.010' => '0.010'
                                ],
                                'attr' => ['class' => 'form-control'],
                                'label' => $param->getTitle()
                            ]
                        );
                    } else {
                        $form->add(
                            $param->getName(),
                            TextType::class,
                            [
                                //'constraints' => [new NotBlank()],
                                'attr' => ['class' => 'form-control'],
                                'label' => $param->getTitle()
                            ]
                        );
                    }

                }
            }
        });
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            //'data_class' => AdTradeInput::class,
            'algorithm' => null,
            'allow_extra_fields' => true,
		]);
    }

    public function getName(): string
    {
        return 'task_params_form';
    }
}
