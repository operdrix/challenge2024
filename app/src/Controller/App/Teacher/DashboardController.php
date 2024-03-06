<?php

namespace App\Controller\App\Teacher;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class DashboardController extends AbstractController
{
    #[Route('/teacher/dashboard', name: 'teacher_dashboard')]
    public function index(): Response
    {
        return $this->render('teacher/dashboard/index.html.twig', [
            'controller_name' => 'DashboardController',
        ]);
    }
}
