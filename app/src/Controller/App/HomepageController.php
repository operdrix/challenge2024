<?php

namespace App\Controller\App;

use App\Service\Mailer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

/**
 * Page d'accueil
 */
class HomepageController extends AbstractController
{
    /**
     * Page d'accueil
     */
    #[Route('/', name: 'homepage')]
    public function index(): Response
    {
        if (!$this->isGranted('IS_AUTHENTICATED') || !$this->isGranted('IS_AUTHENTICATED_FULLY') || !$this->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return $this->redirectToRoute('login');
        }

        // redirection teacher
        if ($this->isGranted('ROLE_TEACHER')) {
            return $this->redirectToRoute('teacher_index');
        }

        // redirection student
        if ($this->isGranted('ROLE_STUDENT')) {
            return $this->redirectToRoute('student_dashboard');
        }

        return $this->render('homepage/index.html.twig', [
            'controller_name' => 'HomepageController',
        ]);
    }
}
