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
            ])
            ->add('comment', TextareaType::class, [
                'required' => false,
                'label' => 'Commentaire',
            ])
            ->add('isValidated', CheckboxType::class , [
                'required' => false,
                'label' => 'Valider la note',
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
