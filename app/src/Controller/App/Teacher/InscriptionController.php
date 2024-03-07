<?php

namespace App\Controller\App\Teacher;

use App\Entity\Inscription;
use App\Entity\Training;
use App\Entity\TrainingSession;
use App\Form\Type\InscriptionFilterType;
use App\Form\Type\InscriptionType;
use App\Form\Type\TrainingSessionFilterType;
use App\Service\FilteredListService;
use App\Service\Interface\StudentServiceInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/teacher/trainings/{training_id}/inscriptions', name: "teacher_inscriptions_")]
class InscriptionController extends AbstractController
{
    #[Route('/new', name: 'new', methods: ['GET', 'POST'])]
    #[Route('/{id}/edit', name: 'edit', methods: ['GET', 'POST'])]
    public function edit(
        #[MapEntity(id: "training_id")] Training $training,
        Request $request,
        EntityManagerInterface $entityManager,
        StudentServiceInterface $studentService,
        ?Inscription $inscription = null,
    ): Response
    {
        if (empty($inscription)) {
            $inscription = new Inscription();
            $inscription->setTraining($training);
        }

        $form = $this->createForm(InscriptionType::class, $inscription);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $type = $form->get("type")->getData();
            if ($type === "grade") {
                foreach ($inscription->getStudents() as $student) {
                    $inscription->removeStudent($student);
                }
            } else {
                $inscription->setGrade(null);
                $createdStudents = $form->get("created_students")->getData();

                $collection = new ArrayCollection($createdStudents);
                $students = $studentService->bulkHandleNewStudent($collection);

                foreach ($students as $student) {
                    $inscription->addStudent($student);
                }
            }

            $entityManager->persist($inscription);
            $entityManager->flush();

            return $this->redirectToRoute('teacher_inscriptions_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('teacher/inscription/edit.html.twig', [
            'inscription' => $inscription,
            'form' => $form,
        ]);
    }

    #[Route("/{id}/show", name: "show")]
    public function show(
        #[MapEntity(id: "training_id")] Training $training,
        Inscription $inscription,
        FilteredListService $filteredListService,
        Request $request
    )
    {
        $filters = [
            "inscription" => $inscription
        ];

        [$pagination, $form] = $filteredListService->prepareFilteredList(
            $request,
            TrainingSessionFilterType::class,
            TrainingSession::class,
            $filters
        );

        return $this->render(
            "teacher/inscription/show.html.twig",
            [
                "pagination" => $pagination,
                "form" => $form,
                "inscription" => $inscription
            ]
        );
    }
}
