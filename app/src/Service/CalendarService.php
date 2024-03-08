<?php

namespace App\Service;

use App\Constant\AppConstant;
use App\Entity\Student;
use App\Entity\Teacher;
use App\Entity\Training;
use App\Entity\TrainingSession;
use App\Service\Interface\CalendarServiceInterface;
use App\Service\Interface\TrainingSessionServiceInterface;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\User\UserInterface;

class CalendarService implements CalendarServiceInterface
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private TrainingSessionServiceInterface $trainingSessionService
    ) {
    }

    public function handleRequest(Request $request, UserInterface $user): array
    {
        $params = [
            'startDate' => new \DateTime($request->request->get('start')),
            'endDate' => new \DateTime($request->request->get('end'))
        ];

        $data = [];

        if ($user instanceof Student) {
            $data = $this->fetchStudentTrainingSessions($user, $params);
        } elseif ($user instanceof Teacher) {
            $data = $this->fetchTeacherTrainingSessions($user, $params);
        }

        return $this->mapTrainingSessionToCalendar($data);
    }

    private function fetchStudentTrainingSessions(Student $student, $params): array
    {
        $individualTrainingSessions = $this->entityManager->getRepository(TrainingSession::class)
            ->findByStudent($student, $params);
        $gradeTrainingSessions = $this->entityManager->getRepository(TrainingSession::class)
            ->findByGrades($student, $params);

        return array_merge($individualTrainingSessions, $gradeTrainingSessions);
    }

    private function fetchTeacherTrainingSessions(Teacher $teacher, $params): array
    {
        return $this->entityManager->getRepository(TrainingSession::class)->findByTeacher($teacher, $params);
    }

    private function mapTrainingSessionToCalendar(array $trainingSessions)
    {
        $map = [];

        /** @var TrainingSession $session */
        foreach ($trainingSessions as $session) {
            $training = $session->getInscription()->getTraining();
            $grade = $session->getInscription()->getGrade();

            $sessionjson = [
                'id' => $session->getId(),
                'allDay' => false,
                'start' => $session->getStartDate()->format(DateTime::ATOM),
                'end' => $session->getStartDate()->modify('+ ' . $session->getLength() . ' minute')->format(DateTime::ATOM),
                'title' => $this->trainingSessionService->generateTitle($session),
                'backgroundColor' => $session->isIsOnline()
                    ? AppConstant::HEX_BG_COLOR_ONLINE_SESSION
                    : AppConstant::HEX_BG_COLOR_DEFAULT_SESSION,
                'textColor' => 'black',
                'borderColor' => '#6b7280',
                'extentedProps' => [
                    'trainingId' => $training->getId(),
                    'trainingTitle' => $training->getTitle(),
                    'trainingDifficulty' => $training->getDifficulty(),
                    'teacherName' => $training->getTeacher()->getLastname() . ' '
                        . $training->getTeacher()->getFirstname(),
                    'isOnline' => $session->isIsOnline(),
                    'sessionLink' => $session->getSessionLink(),
                    'place' => $session->getPlace(),
                    'sessionDate' => $session->getStartDate()->format('h:i d/m')
                ]
            ];

            if (!is_null($grade)) {
                $sessionjson['extentedProps']['gradeId'] = $grade->getId();
                $sessionjson['extentedProps']['gradeLabel'] = $grade->getLabel();
            } else {
                $students = [];
                foreach ($session->getInscription()->getStudents() as $student) {
                    $students[] = $student->getLastname() . ' '
                        . $student->getFirstname();
                }

                $sessionjson['extentedProps']['students'] = $students;
            }

            $map[] = $sessionjson;
        }

        return $map;
    }
}
