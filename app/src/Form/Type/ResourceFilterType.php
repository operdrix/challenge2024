<?php

namespace App\Form\Type;

use App\Enum\ResourceTypeEnum;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Filtre resource
 */
class ResourceFilterType extends AbstractType
{
    /**
     * {@inheritDoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title')
            ->add(
                'type',
                EnumType::class,
                [
                    "class" => ResourceTypeEnum::class,
                    "choice_label" => "value"
                ]
            );
    }
}
