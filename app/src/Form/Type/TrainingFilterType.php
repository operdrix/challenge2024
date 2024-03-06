<?php

namespace App\Form\Type;

use App\Entity\TrainingCategory;
use App\Enum\DifficultyEnum;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Filtre cours
 */
class TrainingFilterType extends AbstractType
{
    /**
     * {@inheritDoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(
                'title',
                TextType::class,
                [
                    "required" => false
                ]
            )
            ->add(
                'difficulty',
                EnumType::class,
                [
                    "class" => DifficultyEnum::class,
                    "choice_name" => "value",
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
            "method" => "GET",
            "csrf_protection" => false
        ]);
    }
}
