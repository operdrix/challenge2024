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
                    'class' => 'form-control',
                    'placeholder' => 'Nombre de points',
                    'value' => $manualAnswer->getResult(),
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
