<?php

namespace App\Security\Voter;

use App\Entity\Admin;
use App\Entity\Teacher;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

class TrainingSessionVoter extends Voter
{
    public const VIEW_SESSION = 'VIEW_SESSION';

    protected function supports(string $attribute, mixed $trainingSession): bool
    {

        return in_array($attribute, [self::VIEW_SESSION])
            && $trainingSession instanceof \App\Entity\TrainingSession;
    }

    protected function voteOnAttribute(string $attribute, mixed $trainingSession, TokenInterface $token): bool
    {
        $user = $token->getUser();

        if (!$user instanceof Teacher && !$user instanceof Admin) {
            return false;
        }

        return match ($attribute) {
            self::VIEW_SESSION => $this->canView($trainingSession, $user),
            default => false,
        };

        return false;
    }

    private function canView(\App\Entity\TrainingSession $trainingSession, Teacher $teacher): bool
    {
        return $teacher->getTrainings()->contains($trainingSession->getInscription()->getTraining());
    }
}
