<?php

namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Filtre élève
 */
class StudentFilterType extends AbstractType
{
    /**
     * {@inheritDoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(
                'firstname',
                TextType::class,
                [
                    "required" => false
                ]
            )
            ->add(
                'lastname',
                TextType::class,
                [
                    "required" => false
                ]
            )
            ->add(
                'email',
                EmailType::class,
                [
                    "required" => false
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
            "csrf_protection" => false,
            "method" => "GET"
        ]);
    }
}
