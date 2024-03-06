<?php

namespace App\Form\Type;

use App\Entity\Grade;
use App\Form\Type\StudentType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GradeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('label', TextType::class, [
                'label' => 'Nom',
                'attr' => [
                    'placeholder' => 'Nom de la classe'
                ]
            ])
            ->add('students', CollectionType::class, [
                'label' => 'Étudiants',
                'by_reference' => false,
                'entry_type' => StudentType::class,
                'entry_options' => ['label' => false],
                'allow_add' => true,
                "row_attr" => [
                    "class" => "space-y-3"
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Grade::class,
        ]);
    }
}
