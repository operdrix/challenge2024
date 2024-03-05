<?php

namespace App\Controller\Admin;

use App\Entity\Quiz;
use App\Form\QuizType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class QuizCrudController extends AbstractController
{
    #[Route('/quiz/crud', name: 'app_quiz_crud')]
    public function index(Request $request, EntityManagerInterface $em): Response
    {
        $quiz = new Quiz();

        $form = $this->createForm(QuizType::class, $quiz);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // $form->getData() holds the submitted values
            // but, the original `$quiz` variable also has the same data
            $quiz = $form->getData();

            // ... perform some action, such as saving the task to the database
            // for example, if Task is a Doctrine entity, save it!

             $em->persist($quiz);
             $em->flush();

            return $this->redirectToRoute('homepage');
        }


        return $this->render('quiz_crud/index.html.twig', [
            'controller_name' => 'QuizCrudController',
            'form' => $form,
        ]);
    }
}
