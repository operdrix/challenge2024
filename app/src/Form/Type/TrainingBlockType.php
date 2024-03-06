<?php

namespace App\Form\Type;

use App\Entity\Progress;
use App\Entity\Quiz;
use App\Entity\Resource;
use App\Entity\Training;
use App\Entity\TrainingBlock;
use App\Entity\TrainingSession;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TrainingBlockType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title')
            ->add(
                'content',
                CKEditorType::class
            )
            ->add('position')
            ->add('resources', EntityType::class, [
                'class' => Resource::class,
                'choice_label' => 'id',
                'multiple' => true,
                "autocomplete" => true,
                "help" => "Si vous ne voyez pas de resources merci d'en ajouter auparavant"
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => TrainingBlock::class,
        ]);
    }
}
