<?php

namespace App\Form\Type;

use App\Entity\School;
use App\Repository\SchoolRepository;
use Doctrine\ORM\QueryBuilder;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\NotBlank;

class ImportType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('school', EntityType::class, [
                'label' => 'Organisme de formation',
                'class' => School::class,
                'choice_label' => 'name',
                'expanded' => false,
                'multiple' => false,
                'attr' => [
                    'placeholder' => 'Veuilelz choisir un organisme de formation'
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez choisir un organisme de formation'
                    ])
                ],
                'query_builder' => function (SchoolRepository $repo) use ($options): QueryBuilder {
                    return $repo->createQueryBuilder('s')
                        ->where('s.teacher = :teacher')
                        ->setParameter('teacher', $options['teacher'])
                        ->orderBy('s.name');
                }
            ])
            ->add('uploadedFile', FileType::class, [
                'label' => 'Fichier csv',
                'constraints' => [
                    new File([
                        'maxSize' => '10M',
                        'mimeTypes' => ['text/csv', 'text/plain'],
                        'mimeTypesMessage' => 'Veuillez choisir un fichier csv'
                    ])
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'teacher' => null
        ]);
    }
}
