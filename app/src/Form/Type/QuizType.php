<?php

namespace App\Form\Type;

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
                'required' => true,
            ])
            ->add('isOpened', CheckboxType::class, [
                'label' => 'Disponible aux élèves',
                'label_attr' => [
                    'class' => 'm-0'
                ],
                'attr' => [
                    'class' => "w-4 h-4 mr-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
                ],
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
                'choice_label' => 'title',
                'autocomplete' => 'true',
                'label' => 'Formation',
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
                'delete_empty' => true,
                'label' => false,
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
