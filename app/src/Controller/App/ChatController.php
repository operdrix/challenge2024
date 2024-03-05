<?php

namespace App\Controller\App;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

/**
 * Écran chat
 */
#[Route('/chats', name: 'chats_')]
class ChatController extends AbstractController
{
    /**
     * Liste des chats
     */
    #[Route('/', name: 'index')]
    public function index(): Response
    {
        return $this->render('chat/index.html.twig');
    }

    /**
     * Conversastio
     */
    #[Route("/{id}/conversation")]
    public function conversation()
    {
        return $this->render("chat/conversation.html.twig");
    }
}
