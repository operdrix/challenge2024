<?php

namespace App\Controller\App;

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


class DashboardStudentController extends AbstractController
{
    #[Route('/dashboard/student', name: 'app_dashboard_student')]
    public function index(
        TrainingRepository $trainingRepository
    ): Response
    {
        return $this->render('dashboard_student/index.html.twig', [
            'trainings' => $trainingRepository->findAll()
        ]);
    }

    #[Route('/dashboard/student/{id}', name: 'show', methods: ['GET'])]
    public function show(Training $training): Response
    {
        return $this->render('dashboard_student/show.html.twig', [
            'training' => $training,
        ]);
    }
}