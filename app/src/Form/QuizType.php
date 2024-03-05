<?php

namespace App\Form;

use App\Entity\Quiz;
use App\Entity\Training;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class QuizType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('label', TextType::class, [
                'label' => 'Nom du quiz',
            ])
            ->add('isOpened', CheckboxType::class, [
                'label' => 'Ouvert',
                'required' => false,
            ])
            ->add('duration', IntegerType::class, [
                'label' => 'Durée (en minutes)',
                'required' => false,
            ])
            ->add('limitDate', DateType::class, [
                'widget' => 'single_text',
                'label' => 'Date limite',
                'required' => false,
            ])
            ->add('training', EntityType::class, [
                'class' => Training::class,
                'choice_label' => 'id',
            ])
            ->add('quizQuestions', CollectionType::class, [
                'entry_type' => QuestionsType::class,
                'entry_options' => ['label' => false],
                'row_attr' => [
                    'class' => 'p-4',
                    'data-controller' => "quiz-question-answer"
                ],
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Quiz::class,
        ]);
    }
}
