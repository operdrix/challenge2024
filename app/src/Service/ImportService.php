<?php

namespace App\Service;

use App\Entity\Teacher;
use App\Entity\School;
use App\Entity\Grade;
use App\Entity\Student;
use App\Service\Interface\ImportServiceInterface;
use App\Service\Interface\StudentServiceInterface;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class ImportService implements ImportServiceInterface
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private StudentServiceInterface $studentService
    ) {
    }

    public function importCSV(UploadedFile $file, Teacher $teacher, School $school): Grade
    {
        $grade = new Grade();
        if (($handle = fopen($file->getPathname(), 'r')) !== false) {
            $isFirst = true;
            while (($data = fgetcsv($handle)) !== false) {
                if ($isFirst) {
                    $grade = $this->csvHandleHeader($data, $school, $teacher);
                    $isFirst = false;
                    continue;
                }

                $student = $this->csvHandleRow($data);
                $grade->addStudent($student);
            }
        }

        $this->entityManager->flush();

        return $grade;
    }

    private function csvHandleHeader(array $header, School $school, Teacher $teacher): Grade
    {
        $grade = $this->entityManager->getRepository(Grade::class)->findOneBy([
            'label' => $header[0],
            'school' => $school
        ]);

        if (is_null($grade)) {
            $grade = new Grade();
            $grade->setSchool($school);
            $grade->setLabel($header[0]);
            $grade->setTeacher($teacher);

            $this->entityManager->persist($grade);
        }

        return $grade;
    }

    private function csvHandleRow(array $data): Student
    {
        $student = $this->entityManager->getRepository(Student::class)->findOneBy(['email' => $data[0]]);

        if (is_null($student)) {
            $student = new Student();
            $student->setEmail($data[0]);
            $student->setFirstname($data[1]);
            $student->setLastname($data[2]);
            $student->setBirthdate(new \DateTimeImmutable($data[3]));
            $student->setPhoneNumber($data[4]);
            $student->setAddress($data[5]);

            $this->entityManager->persist($student);

            $this->studentService->sendNewStudentRegisterMail($student);
        }

        return $student;
    }
}
