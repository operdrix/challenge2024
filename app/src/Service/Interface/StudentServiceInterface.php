<?php

namespace App\Service\Interface;

use App\Entity\Grade;
use App\Entity\Student;
use Doctrine\Common\Collections\Collection;

interface StudentServiceInterface
{
    /**
     * Handle new student from grade or individuals
     * Override new student object by existing one if exist otherwise create a new student
     */
    public function handleNewStudent(Student $student, ?Grade $grade): Student;

    /**
     * Bulk handle new student from grade
     */
    public function bulkHandleNewStudent(Collection $students, ?Grade $grade): Collection;

    /**
     * Control if the student has an account 
     */
    public function retrieveStudentByEmail(Student $student): ?Student;

    /**
     * Send register email to student
     */
    public function sendNewStudentRegisterMail(Student $student);
}
