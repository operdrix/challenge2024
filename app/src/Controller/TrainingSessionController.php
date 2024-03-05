<?php

namespace App\Controller;

use App\Entity\Inscription;
use App\Entity\Training;
use App\Entity\TrainingSession;
use App\Form\TrainingSessionType;
use App\Repository\TrainingSessionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('teacher/trainings/{idTraining}/inscriptions/{idInscription}/sessions', name: 'app_training_session_')]
class TrainingSessionController extends AbstractController
{
    #[Route('/', name: 'index', methods: ['GET'])]
    public function index(
        TrainingSessionRepository $trainingSessionRepository,
        #[MapEntity(id: "idTraining")] Training       $training,
        #[MapEntity(id: "idInscription")] Inscription $inscription,

    ): Response
    {
        return $this->render('training_session/index.html.twig', [
            'training_sessions' => $trainingSessionRepository->findAll(),
            'training' => $training,
            'inscription' => $inscription,
        ]);
    }

    #[Route('/new', name: 'new', methods: ['GET', 'POST'])]
    public function new(
        Request $request,
        EntityManagerInterface $entityManager,
        #[MapEntity(id: "idTraining")] Training       $training,
        #[MapEntity(id: "idInscription")] Inscription $inscription,
    ): Response
    {
        $trainingSession = new TrainingSession();
        $form = $this->createForm(TrainingSessionType::class, $trainingSession);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($trainingSession);
            $entityManager->flush();

            return $this->redirectToRoute('app_training_session_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('training_session/new.html.twig', [
            'training_session' => $trainingSession,
            'form' => $form,
            'training' => $training,
            'inscription' => $inscription,
        ]);
    }

    #[Route('/{idSession}', name: 'show', methods: ['GET'])]
    public function show(
        #[MapEntity(id: "idTraining")] Training       $training,
        #[MapEntity(id: "idInscription")] Inscription $inscription,
        #[MapEntity(id: "idSession")] TrainingSession $trainingSession,
    ): Response
    {
        return $this->render('training_session/show.html.twig', [
            'training_session' => $trainingSession,
            'training' => $training,
            'inscription' => $inscription,
        ]);
    }

    #[Route('/{idSession}/edit', name: 'edit', methods: ['GET', 'POST'])]
    public function edit(
        Request $request,
        EntityManagerInterface $entityManager,
        #[MapEntity(id: "idTraining")] Training       $training,
        #[MapEntity(id: "idInscription")] Inscription $inscription,
        #[MapEntity(id: "idSession")] TrainingSession $trainingSession,
    ): Response
    {
        $form = $this->createForm(TrainingSessionType::class, $trainingSession);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute(
                'app_training_session_index',
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
        TrainingSession $trainingSession,
        EntityManagerInterface $entityManager,
        #[MapEntity(id: "idTraining")] Training       $training,
        #[MapEntity(id: "idInscription")] Inscription $inscription,
        #[MapEntity(id: "idSession")] TrainingSession $session,
    ): Response
    {
        if ($this->isCsrfTokenValid('delete'.$trainingSession->getId(), $request->request->get('_token'))) {
            $entityManager->remove($trainingSession);
            $entityManager->flush();
        }

        return $this->redirectToRoute(
            'app_training_session_index',
            ['idTraining' => $training->getId(), 'idInscription' => $inscription->getId()],
            Response::HTTP_SEE_OTHER);
    }
}
