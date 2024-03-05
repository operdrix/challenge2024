<?php

namespace App\Controller\App;

use App\Entity\Inscription;
use App\Entity\Training;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/teacher', name: "teacher_")]
class TeacherController extends AbstractController
{
    #[Route('/trainings', name: 'trainings')]
    public function trainings(): Response
    {
        return $this->render('teacher/trainings.html.twig', [
            'controller_name' => 'TeacherController',
        ]);
    }

    #[Route('/trainings/{idTraining}/inscriptions/{idInscription}/sessions', name: 'trainings_inscriptions_sessions')]
    public function inscriptionsSessions(
        #[MapEntity(id: "idTraining")] Training       $training,
        #[MapEntity(id: "idInscription")] Inscription $inscription,
    ): Response
    {
        return $this->render('teacher/inscriptions_sessions.html.twig', [
            'controller_name' => 'TeacherController',
        ]);
    }
}
