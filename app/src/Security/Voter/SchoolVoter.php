<?php

namespace App\Security\Voter;

use App\Entity\School;
use App\Entity\Teacher;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class SchoolVoter extends Voter
{
    const EDIT = 'edit';
    const VIEW = 'view';
    const DELETE = 'delete';

    const ATTRIBUTES = [
        self::EDIT,
        self::VIEW,
        self::DELETE
    ];

    protected function supports(string $attribute, mixed $subject): bool
    {
        if (!in_array($attribute, self::ATTRIBUTES)) {
            return false;
        }

        if (!$subject instanceof School) {
            return false;
        }

        return true;
    }

    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();

        if (!$user instanceof Teacher) {
            return false;
        }

        /** @var School $school */
        $school = $subject;

        return match ($attribute) {
            self::EDIT => $this->canEdit($school, $user),
            self::VIEW => $this->canView($school, $user),
            self::DELETE => $this->canDelete($school, $user),
            default => throw new \LogicException('Unrecognized attribute for school')
        };
    }

    private function canEdit(School $school, Teacher $teacher): bool
    {
        // Si c'est un organisme lié au formateur ou nouvel organisme
        return $teacher === $school->getTeacher() || is_null($school);
    }

    private function canView(School $school, Teacher $teacher): bool
    {
        return $this->canEdit($school, $teacher);
    }

    private function canDelete(School $school, Teacher $teacher): bool
    {
        return $this->canEdit($school, $teacher);
    }
}
