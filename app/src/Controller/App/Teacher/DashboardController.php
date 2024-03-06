<?php

namespace App\Controller\App\Teacher;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/teacher', name: 'teacher_')]
class DashboardController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(
        
    ): Response
    {
        return $this->render('teacher/dashboard/index.html.twig', [
            'controller_name' => 'DashboardController',
        ]);
    }
}
