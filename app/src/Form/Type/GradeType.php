<?php

namespace App\Form\Type;

use App\Entity\Grade;
use App\Entity\Student;
use App\Form\Type\StudentType;
use App\Repository\StudentRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GradeType extends AbstractType
{
    public function __construct(
        private readonly Security $security
    )
    {
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('label', TextType::class, [
                'label' => 'Nom',
                'attr' => [
                    'placeholder' => 'Nom de la classe'
                ]
            ])
            ->add('already_created_students', EntityType::class, [
                'label' => 'Étudiants déjà créés',
                'class' => Student::class,
                "choice_label" => "email",
                "mapped" => false,
                "multiple" => true,
                "autocomplete" => true,
                "query_builder" => function (StudentRepository $studentRepository) {
                    return $studentRepository->getBaseQueryBuilder([
                        "teacher" => $this->security->getUser()
                    ]);
                }
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
