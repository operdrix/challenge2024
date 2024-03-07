<?php

namespace App\Form\Type;

use App\Entity\Grade;
use App\Entity\Inscription;
use App\Entity\Student;
use App\Entity\Training;
use App\Repository\GradeRepository;
use App\Repository\InscriptionRepository;
use App\Repository\StudentRepository;
use App\Repository\TrainingRepository;
use Doctrine\ORM\QueryBuilder;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Formulaire d'inscription
 */
class InscriptionType extends AbstractType
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
            ->add(
                "type",
                ChoiceType::class,
                [
                    "choices" => [
                        "Étudiants" => "students",
                        "Classe" => "grade"
                    ]
                ]
            )
            ->add('students', EntityType::class, [
                "label" => "Étudiants déjà créés",
                'class' => Student::class,
                'choice_label' => 'email',
                'multiple' => true,
                "autocomplete" => true,
                "query_builder" => function (StudentRepository $studentRepository) {
                    return $studentRepository->getBaseQueryBuilder([
                        "teacher" => $this->security->getUser()
                    ]);
                }
            ])
            ->add('created_students', CollectionType::class, [
                "label" => "Créé des étudiants",
                'entry_type' => StudentType::class,
                "mapped" => false,
                "row_attr" => [
                    "class" => "space-y-3"
                ],
                "allow_add" => true
            ])
            ->add('grade', EntityType::class, [
                'class' => Grade::class,
                'choice_label' => 'label',
                "autocomplete" => true,
                "query_builder" => function (GradeRepository $gradeRepository) {
                    return $gradeRepository->getBaseQueryBuilder([
                        "teacher" => $this->security->getUser()
                    ]);
                },
                "required" => false
            ])
        ;
    }

    /**
     * {@inheritDoc}
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Inscription::class,
        ]);
    }
}
