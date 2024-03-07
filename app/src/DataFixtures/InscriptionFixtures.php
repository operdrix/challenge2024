<?php

namespace App\DataFixtures;

use App\Entity\Inscription;
use App\Entity\Progress;
use App\Entity\TrainingSession;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class InscriptionFixtures extends Fixture implements DependentFixtureInterface
{

    public const TRAINING_1_INSCRIPTION = 'training1_inscription';
    public const TRAINING_2_INSCRIPTION = 'training2_inscription';
    public const INSCRIPTION_1_SESSION_1 = 'inscription1_session1';
    public const INSCRIPTION_1_SESSION_2 = 'inscription1_session2';
    public const INSCRIPTION_1_SESSION_3 = 'inscription1_session3';

    public function load(ObjectManager $manager): void
    {
        // Ajout des inscriptions aux trainings
        $inscription1 = new Inscription();
        $inscription1->setTraining($this->getReference(TrainingFixtures::TEACHER_1_TRAINING_1));
        $inscription1->setGrade($this->getReference(GradeFixtures::TEACHER_1_SCHOOL_1_GRADE_1));
        $inscription1->setType('grade');
        $manager->persist($inscription1);
        foreach ($inscription1->getGrade()->getStudents() as $student) {
            $progress = new Progress();
            $progress->setStudent($student);
            $progress->setInscription($inscription1);
            $manager->persist($progress);
        }

        $inscription2 = new Inscription();
        $inscription2->setTraining($this->getReference(TrainingFixtures::TEACHER_1_TRAINING_2));
        $inscription2->addStudent($this->getReference(UsersFixtures::STUDENT_1));
        $inscription2->addStudent($this->getReference(UsersFixtures::STUDENT_2));
        $inscription2->addStudent($this->getReference(UsersFixtures::STUDENT_4));
        $inscription2->setType('students');
        $manager->persist($inscription2);
        foreach ($inscription2->getStudents() as $student) {
            $progress = new Progress();
            $progress->setStudent($student);
            $progress->setInscription($inscription2);
            $manager->persist($progress);
        }

        // Ajout des sessions aux inscriptions
        $session1 = new TrainingSession();
        $session1->setInscription($inscription1);
        $session1->setLength(60);
        $session1->setStartDate(new \DateTimeImmutable('2024-03-08 08:00:00'));
        $session1->addTrainingBlock($this->getReference(TrainingFixtures::TRAINING_1_BLOCK_1));
        $session1->addTrainingBlock($this->getReference(TrainingFixtures::TRAINING_1_BLOCK_2));
        $session1->setPlace('ESGI - Salle 301');
        $manager->persist($session1);

        $session2 = new TrainingSession();
        $session2->setInscription($inscription1);
        $session2->setLength(60);
        $session2->setStartDate(new \DateTimeImmutable('2024-03-08 09:45:00'));
        $session2->addTrainingBlock($this->getReference(TrainingFixtures::TRAINING_1_BLOCK_3));
        $session2->addTrainingBlock($this->getReference(TrainingFixtures::TRAINING_1_BLOCK_4));
        $session2->setIsOnline(true);
        $session2->setSessionLink("https://google.com");
        $manager->persist($session2);

        $session3 = new TrainingSession();
        $session3->setInscription($inscription1);
        $session3->setLength(60);
        $session3->setStartDate(new \DateTimeImmutable('2024-03-08 13:30:00'));
        $session3->addTrainingBlock($this->getReference(TrainingFixtures::TRAINING_1_BLOCK_5));
        $session3->addTrainingBlock($this->getReference(TrainingFixtures::TRAINING_1_BLOCK_6));
        $session3->setPlace('ESGI - Salle 303');
        $manager->persist($session3);

        $manager->flush();

        $this->addReference(self::TRAINING_1_INSCRIPTION, $inscription1);
        $this->addReference(self::TRAINING_2_INSCRIPTION, $inscription2);
        $this->addReference(self::INSCRIPTION_1_SESSION_1, $session1);
        $this->addReference(self::INSCRIPTION_1_SESSION_2, $session2);
        $this->addReference(self::INSCRIPTION_1_SESSION_3, $session3);
    }

    public function getDependencies()
    {
        return [
            UsersFixtures::class,
            SchoolFixtures::class,
            GradeFixtures::class,
            TrainingFixtures::class,
        ];
    }
}
