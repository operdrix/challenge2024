<?php

namespace App\Service\Interface;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\User\UserInterface;

interface CalendarServiceInterface
{
    /**
     * Fetch data for the user based on user type
     */
    public function handleRequest(Request $request, UserInterface $user): array;
}
