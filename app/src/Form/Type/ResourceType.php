<?php

namespace App\Form\Type;

use App\Entity\Resource;
use App\Entity\Training;
use App\Enum\ResourceTypeEnum;
use App\Repository\TrainingRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Formulaire resource
 */
class ResourceType extends AbstractType
{
    /**
     * Constructor
     */
    public function __construct(
        private readonly Security $security
    )
    {
    }

    /**
     * {@inheritDoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class)
            ->add(
                "type",
                EnumType::class,
                [
                    "class" => ResourceTypeEnum::class
                ]
            )
            ->add(
                'link',
                UrlType::class,
                [
                    "default_protocol" => "https"
                ]
            )
            ->add(
                'training',
                EntityType::class,
                [
                    "class" => Training::class,
                    "autocomplete" => true,
                    "choice_label" => "title",
                    "query_builder" => function (TrainingRepository $repository) {
                        return $repository->getBaseQueryBuilder([], $this->security->getUser());
                    }
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
            'data_class' => Resource::class,
        ]);
    }
}
