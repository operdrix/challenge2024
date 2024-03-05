<?php

namespace App\Security\Voter;

use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

class TrainingSessionVoter extends Voter
{
    public const SESSIONS_VIEW = 'sessions_view';
    public const SESSION_VIEW = 'session_view';

    protected function supports(string $attribute, mixed $trainingSession): bool
    {
        return in_array($attribute, [self::SESSIONS_VIEW, self::SESSION_VIEW])
            && $trainingSession instanceof \App\Entity\TrainingSession;
    }

    protected function voteOnAttribute(string $attribute, mixed $trainingSession, TokenInterface $token): bool
    {
        $user = $token->getUser();

        // if the user is anonymous, do not grant access
        if (!$user instanceof UserInterface) {
            return false;
        }

        // Vérifie si l'utilisateur n'a pas le rôle ROLE_TEACHER
        if (!$user->hasRole('ROLE_TEACHER')) {
            return false;
        }

        switch ($attribute) {
            case self::SESSIONS_VIEW:
                // On vérifie si le cours associé à la session appartient à l'utilisateur
                if ($trainingSession->getInscription()->getTraining()->getTeacher() === $user) {
                    return true;
                }
                return true;
            case self::SESSION_VIEW:
                return true;
        }

        return false;
    }
}
