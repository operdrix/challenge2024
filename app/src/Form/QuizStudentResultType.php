<?php

namespace App\Form;

use App\Entity\Inscription;
use App\Entity\Quiz;
use App\Entity\QuizStudentResult;
use App\Entity\Student;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class QuizStudentResultType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('value', NumberType::class, [
                'required' => true,
                'label' => 'Note obtenue (sur ' . $options['max_points'] . ' au total)',
                'label_attr' => [
                    'class' => 'block mb-2 text-sm font-medium text-gray-900 dark:text-white'
                ],
            ])
            ->add('comment', TextareaType::class, [
                'required' => false,
                'label' => 'Commentaire',
                'label_attr' => [
                    'class' => 'block mb-2 text-sm font-medium text-gray-900 dark:text-white'
                ],
            ])
            ->add('isValidated', CheckboxType::class , [
                'required' => false,
                'label' => 'Valider la note',
                'row_attr' => [
                    'class' => 'flex items-center mb-4'
                ],
                'label_attr' => [
                    'class' => 'ms-2 text-sm font-medium text-gray-900 dark:text-gray-300'
                ],
                'attr' => [
                    'class' => 'w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => QuizStudentResult::class,
            'max_points' => 0,
        ]);
    }
}
