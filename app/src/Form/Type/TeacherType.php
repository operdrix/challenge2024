<?php

namespace App\Form\Type;

use App\Entity\Teacher;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Formulaire d'un prof
 */
class TeacherType extends AbstractType
{
    /**
     * {@inheritDoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(
                'firstname',
                TextType::class
            )
            ->add(
                'lastname',
                TextType::class

            )
            ->add(
                'birthdate',
                DateType::class,
                [
                    "widget" => "single_text",
                    "required" => false
                ]
            )
            ->add(
                'email',
                EmailType::class
            )
            ->add(
                'phoneNumber',
                TextType::class,
                [
                    "required" => false
                ]
            )
            ->add(
                'plainPassword',
                RepeatedType::class,
                [
                    "type" => PasswordType::class,
                    'required' => false,
                    'first_options'  => ['label' => 'Password'],
                    'second_options' => ['label' => 'Repeat Password'],
                ]
            )
        ;
    }

    /**
     * {@inheritDoc}
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Teacher::class,
        ]);
    }
}
