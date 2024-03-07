<?php

namespace App\Form\Type;

use App\Entity\Training;
use App\Repository\TrainingRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class InscriptionFilterType extends AbstractType
{
    public function __construct(
        private readonly Security $security
    )
    {
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(
                'training',
                EntityType::class,
                [
                    "class" => Training::class,
                    "choice_label" => function (Training $training) {
                        return $training->getTitle() . ' (' . $training->getTeacher()->getEmail() . ")";
                    },
                    "required" => false,
                    "autocomplete" => true,
                    "query_builder" => function (TrainingRepository $trainingRepository) {
                        return $trainingRepository->getBaseQueryBuilder([
                            "student" => $this->security->getUser()
                        ]);
                    }
                ]
            )
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            "method" => "GET"
        ]);
    }
}
