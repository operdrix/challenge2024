<?php

namespace App\Service;

use App\Entity\Grade;
use App\Entity\Student;
use App\Enum\MailTypeEnum;
use App\Service\Interface\MailerServiceInterface;
use App\Service\Interface\StudentServiceInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\EntityManagerInterface;

class StudentService implements StudentServiceInterface
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private MailerServiceInterface $mailerService
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
        $this->mailerService->sendMail(MailTypeEnum::STUDENT_REGISTER, $student->getEmail());
    }

    public function generateRegistrationFlashMessages(Student $student): array
    {
        $messages = [];

        // Generate grade message
        foreach ($student->getGrades() as $grade) {
            $messages['info'][] = "Vous êtes inscris dans la classe "
                . $grade->getLabel() . ' par le formateur '
                . $grade->getTeacher()->getLastname();
            // Generate grade inscription message

            foreach ($grade->getInscriptions() as $inscription) {
                $training = $inscription->getTraining();
                $messages['info'][] = "Vous êtes inscris au cours "
                    . $training->getTitle() . " avec la classe "
                    . $grade->getLabel() . " par le formateur "
                    . $training->getTeacher()->getLastname();
            }
        }

        // generate individual message 
        foreach ($student->getInscriptions() as $inscription) {
            $training = $inscription->getTraining();
            $messages['info'][] = "Vous êtes inscris individuellement au cours "
                . $training->getTitle() . " par le formateur"
                . $training->getTeacher()->getLastname();
        }


        return $messages;
    }

    public function getInscriptions(Student $student): Collection
    {
        $inscriptions = $student->getInscriptions();

        foreach ($student->getGrades() as $grade) {
            $inscriptions = new ArrayCollection(
                array_merge($inscriptions->toArray(), $grade->getInscriptions()->toArray())
            );
        }

        return $inscriptions;
    }
}
