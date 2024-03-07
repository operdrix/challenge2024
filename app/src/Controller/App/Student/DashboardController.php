<?php

namespace App\Controller\App\Student;

use App\Entity\Inscription;
use App\Entity\Training;
use App\Entity\Teacher;
use App\Entity\TrainingBlock;
use App\Form\Type\InscriptionFilterType;
use App\Form\Type\TrainingFilterType;
use App\Repository\TrainingRepository;
use App\Repository\TrainingBlockRepository;
use App\Service\FilteredListService;
use App\Service\Interface\ProgressServiceInterface;
use App\Service\Interface\StudentServiceInterface;
use App\Service\Interface\TrainingServiceInterface;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;

#[Route('/student', name: 'student_')]
class DashboardController extends AbstractController
{
    #[Route('/', name: 'dashboard')]
    public function index(
        FilteredListService $filteredListService,
        Request $request,
    ): Response {
        $filters = [
            "student" => $this->getUser()
        ];

        [$pagination, $form] = $filteredListService->prepareFilteredList(
            $request,
            InscriptionFilterType::class,
            Inscription::class,
            $filters
        );

        return $this->render('student/dashboard/index.html.twig', [
            'pagination' => $pagination,
            'form' => $form
        ]);
    }

    #[Route('/trainings/{id}', name: 'inscription_training', methods: ['GET'])]
    public function show(
        Inscription $inscription
    ): Response {
        return $this->render('student/dashboard/show.html.twig', [
            'training' => $inscription->getTraining(),
            'inscription' => $inscription
        ]);
    }

    #[Route('/trainings/{id}/details/{id_training_block}', name: 'inscription_training_block', methods: ['GET'])]
    public function details(
        Inscription $inscription,
        #[MapEntity(id: 'id_training_block')] TrainingBlock $trainingBlock,
        ProgressServiceInterface $progressService,
        EntityManagerInterface $entityManager
    ): Response {
        /** @var TrainingBlockRepository $trainingBlockRepository */
        $trainingBlockRepository = $entityManager->getRepository(TrainingBlock::class);

        return $this->render('student/dashboard/details.html.twig', [
            'trainingBlock' => $trainingBlock,
            'inscription' => $inscription,
            'isValidated' => $progressService->isTrainingBlockValidated(
                $inscription,
                $this->getUser(),
                $trainingBlock
            ),
            'previousTrainingBlock' => $trainingBlockRepository->findOneBy([
                'training' => $trainingBlock->getTraining(),
                'position' => $trainingBlock->getPosition() - 1
            ]),
            'nextTrainingBlock' => $trainingBlockRepository->findOneBy([
                'training' => $trainingBlock->getTraining(),
                'position' => $trainingBlock->getPosition() + 1
            ])
        ]);
    }

    #[Route('/trainings/{id}/validate/{id_training_block}', name: 'inscription_training_block_validate', methods: ['GET'])]
    public function valdiate(
        Inscription $inscription,
        #[MapEntity(id: 'id_training_block')] TrainingBlock $trainingBlock,
        ProgressServiceInterface $progressService,
        TrainingServiceInterface $trainingService
    ): Response {
        $progressService->validateTrainingBlock(
            $inscription,
            $trainingBlock,
            $this->getUser()
        );

        $nextTraininBlock = $trainingService->findNextTrainingBlock(
            $inscription->getTraining(),
            $trainingBlock->getPosition()
        );

        // Si il n'y pas de prochain block, renvoie vers la page du cours sinon vers le prochain block
        // TODO: page de félicitations pour avoir finis un cours ? 
        if (is_null($nextTraininBlock)) {
            return $this->redirectToRoute('student_inscription_training', [
                'id' => $inscription->getId()
            ]);
        } else {
            return $this->redirectToRoute('student_inscription_training_block', [
                'id' => $inscription->getId(),
                'id_training_block' => $nextTraininBlock->getId()
            ]);
        }
    }
}
