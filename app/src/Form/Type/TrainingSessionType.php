<?php

namespace App\Form\Type;

use App\Entity\Inscription;
use App\Entity\TrainingBlock;
use App\Entity\TrainingSession;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TrainingSessionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('length')
            ->add('startDate', null, [
                'widget' => 'single_text',
            ])
            ->add('isOnline')
            ->add('sessionLink')
            ->add('place')
            ->add('trainingBlocks', EntityType::class, [
                'class' => TrainingBlock::class,
                'choice_label' => 'id',
                'multiple' => true,
            ])
            ->add('inscription', EntityType::class, [
                'class' => Inscription::class,
                'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => TrainingSession::class,
        ]);
    }
}
