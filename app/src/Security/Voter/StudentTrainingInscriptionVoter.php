<?php

namespace App\Security\Voter;

use App\Entity\Inscription;
use App\Entity\Student;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

class StudentTrainingInscriptionVoter extends Voter
{
    public const VIEW = 'view';

    protected function supports(string $attribute, mixed $subject): bool
    {
        return in_array($attribute, [self::VIEW])
            && $subject instanceof Inscription;
    }

    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();

        // if the user is anonymous, do not grant access
        if (!$user instanceof Student) {
            return false;
        }

        // ... (check conditions and return true to grant permission) ...
        return match ($attribute) {
            self::VIEW => $this->canView($user, $subject),
            default => throw new \LogicException('Unrecognized attribute for student training inscription')
        };
    }

    private function canView(Student $student, Inscription $inscription)
    {
        if ($student->getInscriptions()->contains($inscription)) {
            return true;
        }

        foreach ($student->getGrades() as $grade) {
            if ($grade->getInscriptions()->contains($inscription)) {
                return true;
            }
        }

        return false;
    }
}
