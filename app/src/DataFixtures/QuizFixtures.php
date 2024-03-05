<?php

namespace App\DataFixtures;

use App\Entity\Quiz;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class QuizFixtures extends Fixture implements DependentFixtureInterface
{

    public const TRAINING_1_QUIZ_1 = 'training1_quiz1';
    public const TRAINING_1_QUIZ_2 = 'training1_quiz2';

    public function load(ObjectManager $manager): void
    {
        // Création d'un quiz
        $quiz1 = new Quiz();
        $quiz1->setLabel("Quiz installation de Symfony");
        $quiz1->isIsOpened(false);
        $quiz1->setDuration(15);
        $quiz1->setLimitDate(new \DateTimeImmutable('2024-03-08 18:00:00'));
        $quiz1->setTraining($this->getReference(TrainingFixtures::TEACHER_1_TRAINING_1));
        $manager->persist($quiz1);

        $quiz2 = new Quiz();
        $quiz2->setLabel("Quiz dockerisation de Symfony et bundle tailwindcss");
        $quiz2->isIsOpened(false);
        $quiz2->setDuration(30);
        $quiz2->setLimitDate(new \DateTimeImmutable('2024-03-08 18:00:00'));
        $quiz2->setTraining($this->getReference(TrainingFixtures::TEACHER_1_TRAINING_2));

        $manager->flush();

        $this->addReference(self::TRAINING_1_QUIZ_1, $quiz1);
        $this->addReference(self::TRAINING_1_QUIZ_2, $quiz2);
    }

    public function getDependencies()
    {
        return [
            UsersFixtures::class,
            InscriptionFixtures::class,
            TrainingFixtures::class,
        ];
    }
}
