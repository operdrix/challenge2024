<?php

namespace App\Controller\App;

use App\Entity\Student;
use App\Form\Type\StudentFilterType;
use App\Service\FilteredListService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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
    public function index(
        FilteredListService $filteredListService,
        Request $request
    ): Response
    {
        [$pagination, $form] = $filteredListService->prepareFilteredList(
            $request,
            StudentFilterType::class,
            Student::class,
        );

        return $this->render(
            'chat/index.html.twig',
            [
                "pagination" => $pagination,
                "form" => $form
            ]
        );
    }

    /**
     * Conversastio
     */
    #[Route("/{id}/conversation")]
    public function conversation(): Response
    {
        return $this->render("chat/conversation.html.twig");
    }
}
