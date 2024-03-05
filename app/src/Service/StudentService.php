<?php

namespace App\Service;

use App\Entity\Grade;
use App\Entity\Student;
use App\Service\Interface\StudentServiceInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\EntityManagerInterface;

class StudentService implements StudentServiceInterface
{
    public function __construct(
        private EntityManagerInterface $entityManager
    ) {
    }

    public function handleNewStudent(Student $student, ?Grade $grade): Student
    {
        $existingStudent = $this->retrieveStudentByEmail($student);

        if (!is_null($existingStudent)) {
            $student = $existingStudent;
        } else {
            $this->sendNewStudentRegisterMail($student);
        }

        $student->addGrade($grade);

        return $student;
    }

    public function bulkHandleNewStudent(Collection $students, ?Grade $grade): Collection
    {
        $controlledStudents = new ArrayCollection();
        /**
         * @var Student $student
         */
        foreach ($students->getValues() as $student) {
            $controlledStudents->add($this->handleNewStudent($student, $grade));
        }

        return $controlledStudents;
    }

    public function retrieveStudentByEmail(Student $student): ?Student
    {
        return $this->entityManager->getRepository(Student::class)->findOneBy(['email' => $student->getEmail()]);
    }

    public function sendNewStudentRegisterMail(Student $student)
    {
        // TODO: Send register mail to student
    }
}
