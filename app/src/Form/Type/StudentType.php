<?php

namespace App\Form\Type;

use App\Entity\Inscription;
use App\Entity\Student;
use Doctrine\DBAL\Types\DateImmutableType;
use Doctrine\DBAL\Types\DateTimeImmutableType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class StudentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $isStudentParameterPage = $options['isStudentParameterPage'] ?? false;
        $isTeacherView = $options['isTeacherView'] ?? false;
        $builder
            ->add('email', EmailType::class, [
                'label' => 'Email',
                'attr' => [
                    'placeholder' => $isStudentParameterPage ? 'Email' : 'Email de l\'étudiant',
                    'class' => ''
                ],
            ])
            ->add('firstname', TextType::class, [
                'label' => 'Prénom',
                'attr' => [
                    'placeholder' => $isStudentParameterPage ? 'Prénom' : 'Prénom de l\'étudiant'
                ],
            ])
            ->add('lastname', TextType::class, [
                'label' => 'Nom de famille',
                'attr' => [
                    'placeholder' => $isStudentParameterPage ? 'Nom de famille' : 'Nom de famille de l\'étudiant'
                ],
            ]);
        if ($isStudentParameterPage) {
            $builder->add('address', TextType::class, [
                'label' => 'Adresse',
                'attr' => [
                    'placeholder' => 'Adresse'
                ],
                'row_attr' => [
                    'class' => 'py-4'
                ],
            ])
            ->add('phoneNumber', TextType::class, [
                'label' => 'Numéro de téléphone',
                'attr' => [
                    'placeholder' => 'Numéro de téléphone'
                ],
                'row_attr' => [
                    'class' => 'py-4'
                ],
            ])
            ->add('birthdate', DateType::class, [
                "widget" => "single_text",
                'attr' => [
                    'class' => 'py-4 bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500'
                ],
                'row_attr' => [
                    'class' => 'py-4'
                ]
            ]);
        }
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Student::class,
            'isStudentParameterPage' => false,
        ]);
    }
}
