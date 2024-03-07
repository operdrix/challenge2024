<?php

namespace App\Form\Type;

use App\Entity\Inscription;
use App\Entity\Student;
use Doctrine\DBAL\Types\DateImmutableType;
use Doctrine\DBAL\Types\DateTimeImmutableType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class StudentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $isStudentParameterPage = $options['action'] == 'isStudentParameterPage';
        $builder
            ->add('email', EmailType::class, [
                'label' => 'Email',
                'attr' => [
                    'placeholder' => $isStudentParameterPage ? 'Email' : 'Email de l\'étudiant'
                ]
            ])
            ->add('firstname', TextType::class, [
                'label' => 'Prénom',
                'attr' => [
                    'placeholder' => $isStudentParameterPage ? 'Prénom' : 'Prénom de l\'étudiant'
                ]
            ])
            ->add('lastname', TextType::class, [
                'label' => 'Nom de famille',
                'attr' => [
                    'placeholder' => $isStudentParameterPage ? 'Nom de famille' : 'Nom de famille de l\'étudiant'
                ]
            ]);
        if ($isStudentParameterPage) {
            $builder->add('address', TextType::class, [
                'label' => 'Adresse',
                'attr' => [
                    'placeholder' => 'Adresse'
                ]
            ])
            ->add('phoneNumber', TextType::class, [
                'label' => 'Numéro de téléphone',
                'attr' => [
                    'placeholder' => 'Numéro de téléphone'
                ]
            ])
            ->add('birthdate');
        }
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Student::class,
        ]);
    }
}
