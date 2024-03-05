<?php

namespace App\Controller\Admin;

use App\Entity\Quiz;
use App\Form\QuizType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class QuizCrudController extends AbstractController
{
    #[Route('/quiz/crud', name: 'app_quiz_crud')]
    public function index(): Response
    {
        $quiz = new Quiz();

        $form = $this->createForm(QuizType::class, $quiz);


        return $this->render('quiz_crud/index.html.twig', [
            'controller_name' => 'QuizCrudController',
            'form' => $form->createView(),
        ]);
    }
}
