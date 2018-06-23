<?php

namespace App\Form;

use App\Document\UserAd;
use App\Entity\Algorithm;
use App\Model\TaskInput;
use App\Service\TaskManager;
use Doctrine\Bundle\MongoDBBundle\Form\Type\DocumentType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Validator\Constraints\NotBlank;
use App\Form\TaskParamsType;

class TaskInputType extends AbstractType
{
    /**
     * @var TaskManager
     */
    private $tm;

    /**
     * TaskInputType constructor.
     * @param TaskManager $tm
     */
    public function __construct(TaskManager $tm)
    {
        $this->tm = $tm;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'profile_id',
                HiddenType::class
            )
            ->add(
                'title',
                TextType::class,
                [
                    'attr' => ['class' => 'form-control'],
                    'label' => 'Название'
                ]
            )
            ->add(
                'interval',
                TextType::class,
                [
                    'attr' => ['class' => 'form-control'],
                    'label' => 'Интервал запуска (сек)'
                ]
            )
            ->add(
                'algorithm',
                EntityType::class,
                [
                    'constraints' => [new NotBlank()],
                    'placeholder' => '-- Алгоритм --',
                    //'required' => false,
                    'class' => Algorithm::class,
                    'choice_value' => 'name',
                    'choice_label' => function (Algorithm $alg) {
                        return substr($alg->getDescription(), 0, 80);
                    },
                    'attr' => ['class' => 'form-control task-command'],
                    'label' => 'Алгоритм'
                ]
            );

        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) use ($builder){
            /** @var TaskInput $task */
            $task = $event->getData();
            /** @var TaskInputType $form */
            $form = $event->getForm();

            if ($task) {
                // fill ads choices
                if ($profile = $task->getProfile()) {

                    $form->add(
                        'ad',
                        DocumentType::class,
                        [
                            'class' => UserAd::class,
                            'choices' => $this->tm->getUserAds($profile),
                            'choice_value' => 'ad_id',
                            'choice_label' => function (UserAd $ad) {
                                return implode(',', [
                                    $ad->getAdId(),
                                    $ad->getTradeType(),
                                    $ad->getCountrycode(),
                                    $ad->getCurrency(),
                                    "[{$ad->getMinAmount()}:{$ad->getMaxAmount()}]"
                                ]);
                                /*return $ad->printAttrs([
                                    '%d' => $ad->getId(),
                                    '%s' => $ad->getTradeType(),
                                    '%s' => $ad->getCountrycode(),
                                    '%s' => $ad->getCurrency(),
                                    '%s' => "[{$ad->getMinAmount()}:{$ad->getMaxAmount()}]"
                                ]);*/
                            },
                            'attr' => ['class' => 'form-control'],
                            'label' => 'Объявление'
                        ]
                    );
                }
                /** @var Algorithm $alg */
                $alg = $task->getAlgorithm();

                if ($alg) {

                    $form->add(
                        'params',
                        TaskParamsType::class,
                        [
                            'data_class' => $alg->getInputClass(),
                            'algorithm' => $alg
                        ]
                    );
                }
            }
        });
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data-class' => TaskInput::class,
            'allow_extra_fields' => true,
			'csrf_protection' => false
        ]);
    }

    public function getName()
    {
        return 'task_form';
    }
}
