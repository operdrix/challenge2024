<?php

namespace App\Controller\App\Teacher;

use App\Entity\TrainingCategory;
use App\Form\Type\TrainingCategoryFilterType;
use App\Form\Type\TrainingCategoryType;
use App\Service\FilteredListService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/teacher/training-categories', name: "teacher_training_categories_")]
class TrainingCategoryController extends AbstractController
{
    #[Route('/', name: 'index', methods: ['GET'])]
    public function index(
        FilteredListService $filteredListService,
        Request $request,
    ): Response
    {
        $filters = [
            "teacher" => $this->getUser()
        ];

        [$pagination, $form] = $filteredListService->prepareFilteredList(
            $request,
            TrainingCategoryFilterType::class,
            TrainingCategory::class,
            $filters
        );

        return $this->render('teacher/training_category/index.html.twig', [
            "pagination" => $pagination,
            "form" => $form
        ]);
    }

    #[Route('/new', name: 'new', methods: ['GET', 'POST'])]
    #[Route('/{id}/edit', name: 'edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, EntityManagerInterface $em, ?TrainingCategory $trainingCategory = null): Response
    {
        if (empty($trainingCategory)) {
            $trainingCategory = new TrainingCategory();
            $trainingCategory->setTeacher($this->getUser());
        }

        $form = $this->createForm(TrainingCategoryType::class, $trainingCategory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($trainingCategory);
            $em->flush();

            return $this->redirectToRoute('teacher_training_categories_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('teacher/training_category/edit.html.twig', [
            'training_category' => $trainingCategory,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'delete', methods: ['POST'])]
    public function delete(Request $request, TrainingCategory $trainingCategory, EntityManagerInterface $em): Response
    {
        if ($this->isCsrfTokenValid('delete' . $trainingCategory->getId(), $request->request->get('_token'))) {
            $em->remove($trainingCategory);
            $em->flush();
        }

        return $this->redirectToRoute('teacher_training_categories_index', [], Response::HTTP_SEE_OTHER);
    }
}
