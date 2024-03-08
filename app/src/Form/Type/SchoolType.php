<?php

namespace App\Form\Type;

use App\Entity\School;
use App\Entity\Teacher;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class SchoolType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom',
                'attr'  => [
                    'placeholder' => 'Nom de l\'organisme de formation'
                ]
            ])
            ->add('address', TextType::class, [
                'label' => 'Addresse',
                'attr' => [
                    'placeholder' => 'Adresse de l\'organisme de formation'
                ]
            ])
            ->add('contactName', TextType::class, [
                'label' => 'Nom du contact',
                'attr' => [
                    'placeholder' => 'Nom du contact de l\'organisme de formation'
                ]
            ])
            ->add('email', EmailType::class, [
                'label' => 'Email',
                'attr' => [
                    'placeholder' => 'Email du contact',
                    'helper' => 'Veuillez saisir au moins un moyen de contact'
                ],
            ])
            ->add('phoneNumber', TextType::class, [
                'label' => 'Numéro de téléphone',
                'attr' => [
                    'placeholder' => 'Numéro de téléphone du contact',
                    'helper' => 'Veuillez saisir au moins un moyen de contact'
                ]
            ])
            ->add('logo', FileType::class, [
                'label' => 'Logo',
                'mapped' => false,
                'attr' => [
                    'helper' => 'Veuillez choisir un fichier image de type jpeg ou png de moins de 1M'
                ],
                'constraints' => [
                    new File([
                        'maxSize' => '1024k',
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/png'
                        ],
                        'mimeTypesMessage' => 'Veuillez choisir un fichier image de type jpeg ou png'
                    ])
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => School::class,
        ]);
    }
}
