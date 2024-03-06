<?php

namespace App\Controller\App\Teacher;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route("/teacher/categories", name: "teacher_categories")]
class CategoryController extends AbstractController
{
    #[Route('/teacher/category', name: '_')]
    public function index(): Response
    {
        return $this->render('teacher_category/index.html.twig', [
            'controller_name' => 'TeacherCategoryController',
        ]);
    }
}
