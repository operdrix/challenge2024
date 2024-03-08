<?php

namespace App\Form\Type;

use App\Entity\QuizQuestion;
use App\Entity\QuizQuestionStudentAnswer;
use App\Entity\Student;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotNull;

class QuizQuestionStudentAnswerCollectionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        foreach ($options['manualAnswers'] as $manualAnswer) {
            $builder->add($manualAnswer->getId(), IntegerType::class, [
                'mapped' => false,
                'required' => false,
                'label' => $manualAnswer->getContent(),
                'attr' => [
                    'class' => 'bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 mt-4',
                    'placeholder' => 'Nombre de points',
                    'value' => $manualAnswer->getResult(),
                    'min' => '0',
                    'max' => $manualAnswer->getQuizQuestion()->getPoint(),
                ],
                'constraints' => [
                    new NotNull([
                        'message' => 'Veuillez saisir un nombre de points pour cette réponse',
                    ]),
                ],

            ]);
        }
    }
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // ...,
            'manualAnswers' => [],
        ]);
        $resolver->setAllowedTypes('manualAnswers', 'array');
    }
}
