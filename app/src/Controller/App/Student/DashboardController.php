<?php

namespace App\Controller\App\Student;

use App\Entity\Training;
use App\Entity\Teacher;
use App\Repository\TrainingRepository;
use App\Repository\TrainingBlockRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;

#[Route('/student', name: 'student_')]
class DashboardController extends AbstractController
{
    #[Route('/', name: 'dashboard')]
    public function index(
        TrainingRepository $trainingRepository
    ): Response
    {
        return $this->render('student/dashboard/index.html.twig', [
            'trainings' => $trainingRepository->findAll()
        ]);
    }

    #[Route('/trainings/{id}', name: 'show', methods: ['GET'])]
    public function show(Training $training): Response
    {
        return $this->render('student/dashboard/show.html.twig', [
            'training' => $training,
        ]);
    }
}