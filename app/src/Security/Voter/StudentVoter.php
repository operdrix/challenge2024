<?php

namespace App\Security\Voter;

use App\Entity\Student;
use App\Entity\Teacher;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;
use App\Entity\Inscription;
use App\Entity\Grade;

class StudentVoter extends Voter
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

        if (!$subject instanceof Student) {
            return false;
        }

        return true;
    }

    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();

        /** @var Student $student */
        $student = $subject;

        return match ($attribute) {
            self::EDIT => $this->canEdit($student, $user),
            self::VIEW => $this->canView($student, $user),
            self::DELETE => $this->canDelete($student, $user),
            default => throw new \LogicException('Unrecognized attribute for school')
        };
    }

    private function canEdit(Student $student, UserInterface $user): bool
    {
        // Si l'utilisateur est un étudiant, il ne peut voir que son profil 
        if ($user instanceof Student) {
            return $user === $student;
        }

        // Si l'utilisateur est un formateur, il ne peut voir que les étudiants inscris à l'un de ses cours
        if ($user instanceof Teacher) {
            /** @var Inscription $inscription */
            foreach ($student->getInscriptions() as $inscription) {
                if ($inscription->getTraining()->getTeacher() === $user) {
                    return true;
                }
            }

            /** @var Grade $grade */
            foreach ($student->getGrades() as $grade) {
                foreach ($grade->getInscriptions() as $inscription) {
                    if ($inscription->getTraining()->getTeacher() === $user) {
                        return true;
                    }
                }
            }
        }

        return false;
    }

    private function canView(Student $grade, UserInterface $user): bool
    {
        return $this->canEdit($grade, $user);
    }

    private function canDelete(Student $grade, UserInterface $user): bool
    {
        return !$user instanceof Student && $this->canEdit($grade, $user);
    }
}
