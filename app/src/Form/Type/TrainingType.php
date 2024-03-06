<?php

namespace App\Form\Type;

use App\Entity\Teacher;
use App\Entity\Training;
use App\Entity\TrainingCategory;
use App\Enum\DifficultyEnum;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TrainingType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(
                'title',
                TextType::class
            )
            ->add(
                'description',
                TextareaType::class
            )
            ->add('length')
            ->add(
                'difficulty',
                EnumType::class,
                [
                    "class" => DifficultyEnum::class,
                    "choice_label" => "value"
                ]
            )
            ->add('categories', EntityType::class, [
                'class' => TrainingCategory::class,
                'choice_label' => 'label',
                'multiple' => true,
                "autocomplete" => true
            ])

            ->add('trainingBlocks', CollectionType::class, [
                "entry_type" => TrainingBlockType::class,
                'entry_options' => ['label' => false],
                "row_attr" => [
                    "class" => "space-y-3"
                ],
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
                'delete_empty' => true,
                "label" => false
            ])
            ->add('trainingObjectives', CollectionType::class, [
                "entry_type" => TrainingObjectiveType::class,
                'entry_options' => ['label' => false],
                "row_attr" => [
                    "class" => "space-y-3"
                ],
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
                'delete_empty' => true,
                "label" => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Training::class,
        ]);
    }
}
