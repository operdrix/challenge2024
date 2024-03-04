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
        $this->addFlash("success", "Exemple de message toast");
        $this->addFlash("warning", "Exemple de message toast");
        $this->addFlash("danger", "Exemple de message toast");

        return $this->render('homepage/index.html.twig', [
            'controller_name' => 'HomepageController',
        ]);
    }
}
