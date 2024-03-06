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

class QuizQuestionStudentAnswerCollectionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('answers', CollectionType::class, [
                'entry_type' => QuizQuestionStudentAnswerType::class,
                'allow_add' => false,
            ])
        ;
    }
}
