<?php

namespace App\Security\Voter;

use App\Entity\Grade;
use App\Entity\Teacher;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class GradeVoter extends Voter
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

        if (!$subject instanceof Grade) {
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

        /** @var Grade $grade */
        $grade = $subject;

        return match ($attribute) {
            self::EDIT => $this->canEdit($grade, $user),
            self::VIEW => $this->canView($grade, $user),
            self::DELETE => $this->canDelete($grade, $user),
            default => throw new \LogicException('Unrecognized attribute for school')
        };
    }

    private function canEdit(Grade $grade, Teacher $teacher): bool
    {
        return $grade->getTeacher() === $teacher;
    }

    private function canView(Grade $grade, Teacher $teacher): bool
    {
        return $this->canEdit($grade, $teacher);
    }

    private function canDelete(Grade $grade, Teacher $teacher): bool
    {
        return $this->canEdit($grade, $teacher);
    }
}
