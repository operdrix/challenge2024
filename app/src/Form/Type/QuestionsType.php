<?php

namespace App\Form\Type;

use App\Entity\QuizQuestion;
use App\Enum\QuizQuestionTypeEnum;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class QuestionsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Libellé de la question',
            ])
            ->add('type', EnumType::class, [
                'class' => QuizQuestionTypeEnum::class,
                'label' => 'Type de question',
                'attr' => [
                    'data-quiz-question-type-target' => 'type',
                    'data-action' => 'change->quiz-question-answer#changeType',
                ],
                'choice_label' => function ($choice, $key, $value) {
                    return $value;
                },
            ])
            ->add('point', IntegerType::class, [
                'label' => 'Point(s) de la question',
            ])
            ->add('quizQuestionAvailableAnswers', CollectionType::class, [
                'entry_type' => QuizQuestionAvailableAnswerType::class,
                'entry_options' => [
                    'label' => false,
                ],
                'label' => 'Réponses possibles',
                'row_attr' => [
                    'class' => 'p-4 hidden',
                    'data-quiz-question-answer-target' => 'answers',
                ],
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
                'delete_empty' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => QuizQuestion::class,
        ]);
    }
}
