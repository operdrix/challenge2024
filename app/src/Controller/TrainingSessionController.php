<?php

namespace App\Controller;

use App\Entity\Inscription;
use App\Entity\Training;
use App\Entity\TrainingSession;
use App\Form\Type\TrainingSessionType;
use App\Repository\TrainingSessionRepository;
use App\Security\Service\SecurityService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('teacher/trainings/{idTraining}/inscriptions/{idInscription}/sessions', name: 'training_sessions_')]
class TrainingSessionController extends AbstractController
{
    #[Route('/', name: 'index', methods: ['GET'])]
    #[IsGranted('VIEW_INSCRIPTION', subject: 'inscription')]
    public function index(
        TrainingSessionRepository $trainingSessionRepository,
        #[MapEntity(id: "idTraining")] Training       $training,
        #[MapEntity(id: "idInscription")] Inscription $inscription,
        SecurityService $securityService
    ): Response
    {
        if (!$securityService->canViewInscription($inscription, $training)) {
            throw $this->createAccessDeniedException();
        }
        return $this->render('training_session/index.html.twig', [
            'training_sessions' => $trainingSessionRepository->findAll(),
            'training' => $training,
            'inscription' => $inscription,
        ]);
    }

    #[Route('/new', name: 'new', methods: ['GET', 'POST'])]
    #[Route('/{idSession}/edit', name: 'edit', methods: ['GET', 'POST'])]
    #[IsGranted('VIEW_SESSION', subject: 'trainingSession')]
    public function edit(
        Request $request,
        EntityManagerInterface $entityManager,
        #[MapEntity(id: "idTraining")] Training       $training,
        #[MapEntity(id: "idInscription")] Inscription $inscription,
        #[MapEntity(id: "idSession")] ?TrainingSession $trainingSession = null,
        SecurityService $securityService
    ): Response
    {
        if (empty($trainingSession)) {
            $trainingSession = new TrainingSession();
        } else {
            if (!$securityService->canViewSession($inscription, $training, $trainingSession)) {
                throw $this->createAccessDeniedException();
            }
        }

        $form = $this->createForm(TrainingSessionType::class, $trainingSession);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($trainingSession);
            $entityManager->flush();

            return $this->redirectToRoute(
                'training_sessions_index',
                ['idTraining' => $training->getId(), 'idInscription' => $inscription->getId()],
                Response::HTTP_SEE_OTHER);
        }

        return $this->render('training_session/edit.html.twig', [
            'training_session' => $trainingSession,
            'form' => $form,
            'training' => $training,
            'inscription' => $inscription,
        ]);
    }

    #[Route('/{idSession}', name: 'delete', methods: ['POST'])]
    public function delete(
        Request $request,
        EntityManagerInterface $entityManager,
        #[MapEntity(id: "idTraining")] Training       $training,
        #[MapEntity(id: "idInscription")] Inscription $inscription,
        #[MapEntity(id: "idSession")] TrainingSession $trainingSession,
    ): Response
    {
        if ($this->isCsrfTokenValid('delete'.$trainingSession->getId(), $request->request->get('_token'))) {
            $entityManager->remove($trainingSession);
            $entityManager->flush();
        }

        return $this->redirectToRoute(
            'training_sessions_index',
            ['idTraining' => $training->getId(), 'idInscription' => $inscription->getId()],
            Response::HTTP_SEE_OTHER);
    }
}
