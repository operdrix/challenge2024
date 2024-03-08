<?php

namespace App\Controller\App\Teacher;

use App\Entity\Inscription;
use App\Entity\Training;
use App\Entity\TrainingCategory;
use App\Form\Type\InscriptionFilterType;
use App\Form\Type\TrainingFilterType;
use App\Form\Type\TrainingType;
use App\Service\Interface\FilteredListServiceInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/teacher/trainings', name: "teacher_trainings_")]
class TrainingController extends AbstractController
{
    #[Route('/', name: 'index', methods: ['GET'])]
    public function index(
        FilteredListServiceInterface $filteredListService,
        Request $request,
    ): Response {
        $filters = [
            "teacher" => $this->getUser()
        ];

        [$pagination, $form] = $filteredListService->prepareFilteredList(
            $request,
            TrainingFilterType::class,
            Training::class,
            $filters
        );

        return $this->render('teacher/training/index.html.twig', [
            "pagination" => $pagination,
            "form" => $form
        ]);
    }

    #[Route('/new', name: 'new', methods: ['GET', 'POST'])]
    #[Route('/{id}/edit', name: 'edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, EntityManagerInterface $em, ?Training $training = null): Response
    {
        if (empty($training)) {
            $training = new Training();
            $training->setTeacher($this->getUser());
        }

        $form = $this->createForm(TrainingType::class, $training);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($training);
            $em->flush();

            return $this->redirectToRoute('teacher_trainings_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('teacher/training/edit.html.twig', [
            'training' => $training,
            'form' => $form,
        ]);
    }

    #[Route("/{id}/show", name: "show", methods: ["GET"])]
    public function show(
        Training $training,
        FilteredListServiceInterface $filteredListService,
        Request $request
    ): Response {
        $filters = [
            "teacher" => $this->getUser(),
            "training" => $training
        ];

        [$pagination, $form] = $filteredListService->prepareFilteredList(
            $request,
            InscriptionFilterType::class,
            Inscription::class,
            $filters
        );

        return $this->render(
            "teacher/training/show.html.twig",
            [
                "training" => $training,
                "pagination" => $pagination,
                "form" => $form
            ]
        );
    }

    #[Route('/{id}', name: 'delete', methods: ['POST'])]
    public function delete(Request $request, TrainingCategory $trainingCategory, EntityManagerInterface $em): Response
    {
        if ($this->isCsrfTokenValid('delete' . $trainingCategory->getId(), $request->request->get('_token'))) {
            $em->remove($trainingCategory);
            $em->flush();
        }

        return $this->redirectToRoute('teacher_trainings_index', [], Response::HTTP_SEE_OTHER);
    }
}
