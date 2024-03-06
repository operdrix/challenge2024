<?php

namespace App\Controller\App;

use App\Service\Interface\CalendarServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('IS_AUTHENTICATED_FULLY')]
class CalendarController extends AbstractController
{
    #[Route('/calendar', name: 'app_calendar')]
    public function index(): Response
    {

        return $this->render('calendar/index.html.twig', []);
    }

    #[Route('/data', name: 'app_calendar_data', methods: ['POST'])]
    public function data(
        Request $request,
        CalendarServiceInterface $calendarService
    ): JsonResponse {
        $data = $calendarService->handleRequest($request, $this->getUser());

        return new JsonResponse(
            json_encode(array_values($data)),
            Response::HTTP_OK,
            [],
            true
        );
    }
}
