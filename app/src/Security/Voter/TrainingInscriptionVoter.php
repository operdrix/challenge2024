<?php

namespace App\Security\Voter;

use App\Entity\Teacher;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class TrainingInscriptionVoter extends Voter
{
    public const VIEW_INSCRIPTION = 'VIEW_INSCRIPTION';

    protected function supports(string $attribute, mixed $subject): bool
    {
        // replace with your own logic
        // https://symfony.com/doc/current/security/voters.html
        return in_array($attribute, [self::VIEW_INSCRIPTION])
            && $subject instanceof \App\Entity\Inscription;
    }

    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();

        if (!$user instanceof Teacher) {
            return false;
        }

        return match ($attribute) {
            self::VIEW_INSCRIPTION => $this->canView($subject, $user),
            default => false,
        };

        return false;
    }

    private function canView(\App\Entity\Inscription $inscription, Teacher $teacher): bool
    {
        return $teacher->getTrainings()->contains($inscription->getTraining());
    }
}
