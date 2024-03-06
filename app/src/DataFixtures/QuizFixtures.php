<?php

namespace App\DataFixtures;

use App\Entity\Quiz;
use App\Entity\QuizQuestion;
use App\Entity\QuizQuestionAvailableAnswer;
use App\Enum\QuizQuestionTypeEnum;
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
        $quiz1->setIsOpened(false);
        $quiz1->setDuration(15);
        $quiz1->setLimitDate(new \DateTimeImmutable('2024-03-08 18:00:00'));
        $quiz1->setTraining($this->getReference(TrainingFixtures::TEACHER_1_TRAINING_1));

        $question1 = new QuizQuestion();
        $question1->setTitle("Quelle commande permet de créer un nouveau projet Symfony ?");
        $question1->setType(QuizQuestionTypeEnum::TEXT);
        $question1->setPoint(1);
        $question1->setQuiz($quiz1);
        $manager->persist($question1);

        $question2 = new QuizQuestion();
        $question2->setTitle("Est-ce que Symfony est un framework PHP ?");
        $question2->setType(QuizQuestionTypeEnum::YESNO);
        $question2->setPoint(2);
        $question2->setQuiz($quiz1);
        $manager->persist($question2);

        $question3 = new QuizQuestion();
        $question3->setTitle("Symfony est un framework :");
        $question3->setType(QuizQuestionTypeEnum::UNIQUE);

        $availableAnswers = new QuizQuestionAvailableAnswer();
        $availableAnswers->setContent("Python");
        $availableAnswers->setIsCorrect(false);
        $availableAnswers->setQuizQuestion($question3);
        $manager->persist($availableAnswers);

        $availableAnswers = new QuizQuestionAvailableAnswer();
        $availableAnswers->setContent("PHP");
        $availableAnswers->setIsCorrect(true);
        $availableAnswers->setQuizQuestion($question3);
        $manager->persist($availableAnswers);

        $question3->setPoint(2);
        $question3->setQuiz($quiz1);
        $manager->persist($question3);


        $manager->persist($quiz1);

        $quiz2 = new Quiz();
        $quiz2->setLabel("Quiz dockerisation de Symfony et bundle tailwindcss");
        $quiz2->setIsOpened(false);
        $quiz2->setDuration(30);
        $quiz2->setLimitDate(new \DateTimeImmutable('2024-03-08 18:00:00'));
        $quiz2->setTraining($this->getReference(TrainingFixtures::TEACHER_1_TRAINING_2));

        $manager->persist($quiz2);

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
