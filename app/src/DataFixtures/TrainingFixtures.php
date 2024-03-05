<?php

namespace App\DataFixtures;

use App\Entity\Training;
use App\Entity\TrainingBlock;
use App\Entity\TrainingCategory;
use App\Enum\DifficultyEnum;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;


class TrainingFixtures extends Fixture implements DependentFixtureInterface
{
    /**
     * @var \Faker\Generator
     */
    private Generator $faker;
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->faker = Factory::create('fr_FR');
    }


    public const TEACHER_1_TRAINING_1 = 'teacher_1_training1';
    public const TEACHER_1_TRAINING_2 = 'teacher_1_training2';
    public const TRAINING_1_BLOCK_1 = 'training1_block1';
    public const TRAINING_1_BLOCK_2 = 'training1_block2';
    public const TRAINING_1_BLOCK_3 = 'training1_block3';
    public const TRAINING_1_BLOCK_4 = 'training1_block4';
    public const TRAINING_1_BLOCK_5 = 'training1_block5';
    public const TRAINING_1_BLOCK_6 = 'training1_block6';

    public function load(ObjectManager $manager): void
    {

        // Ajout des catégories de formations
        $categorie1 = new TrainingCategory();
        $categorie1->setLabel("Développement");
        $categorie1->setTeacher($this->getReference(UsersFixtures::TEACHER_1));
        $manager->persist($categorie1);

        $categorie2 = new TrainingCategory();
        $categorie2->setLabel("Design");
        $categorie2->setTeacher($this->getReference(UsersFixtures::TEACHER_1));
        $manager->persist($categorie2);

        // Création des Trainings Blocks
        $trainingBlock1 = new TrainingBlock();
        $trainingBlock1->setTitle("Symfony Installation");
        $trainingBlock1->setContent($this->faker->text(200));
        $trainingBlock1->setPosition(1);
        $manager->persist($trainingBlock1);

        $trainingBlock2 = new TrainingBlock();
        $trainingBlock2->setTitle("Symfony Configuration");
        $trainingBlock2->setContent($this->faker->text(200));
        $trainingBlock2->setPosition(2);
        $manager->persist($trainingBlock2);

        $trainingBlock3 = new TrainingBlock();
        $trainingBlock3->setTitle("Symfony Routing");
        $trainingBlock3->setContent($this->faker->text(200));
        $trainingBlock3->setPosition(3);
        $manager->persist($trainingBlock3);

        $trainingBlock4 = new TrainingBlock();
        $trainingBlock4->setTitle("Symfony Controller");
        $trainingBlock4->setContent($this->faker->text(200));
        $trainingBlock4->setPosition(4);
        $manager->persist($trainingBlock4);

        $trainingBlock5 = new TrainingBlock();
        $trainingBlock5->setTitle("Symfony Twig");
        $trainingBlock5->setContent($this->faker->text(200));
        $trainingBlock5->setPosition(5);
        $manager->persist($trainingBlock5);

        $trainingBlock6 = new TrainingBlock();
        $trainingBlock6->setTitle("Symfony Form");
        $trainingBlock6->setContent($this->faker->text(200));
        $trainingBlock6->setPosition(6);
        $manager->persist($trainingBlock6);


        // Ajout des formations
        $training1 = new Training();
        $training1->setTitle("Formation Symfony expert");
        $training1->setDescription("Formation pour devenir un expert en Symfony");
        $training1->setLength(14);
        $training1->setDifficulty(DifficultyEnum::EXPERT);
        $training1->setTeacher($this->getReference(UsersFixtures::TEACHER_1));
        $training1->addCategory($categorie1);
        $training1->addCategory($categorie2);
        $training1->addTrainingBlock($trainingBlock1);
        $training1->addTrainingBlock($trainingBlock2);
        $training1->addTrainingBlock($trainingBlock3);
        $training1->addTrainingBlock($trainingBlock4);
        $training1->addTrainingBlock($trainingBlock5);
        $training1->addTrainingBlock($trainingBlock6);
        $manager->persist($training1);

        $training2 = new Training();
        $training2->setTitle("Formation Symfony débutant");
        $training2->setDescription("Formation pour débuter avec Symfony");
        $training2->setLength(7);
        $training2->setDifficulty(DifficultyEnum::BEGINER);
        $training2->setTeacher($this->getReference(UsersFixtures::TEACHER_1));
        $training2->addCategory($categorie1);
        $training2->addTrainingBlock($trainingBlock1);
        $training2->addTrainingBlock($trainingBlock2);
        $training2->addTrainingBlock($trainingBlock3);
        $manager->persist($training2);

        $manager->flush();

        $this->addReference(self::TEACHER_1_TRAINING_1, $training1);
        $this->addReference(self::TEACHER_1_TRAINING_2, $training2);
        $this->addReference(self::TRAINING_1_BLOCK_1, $trainingBlock1);
        $this->addReference(self::TRAINING_1_BLOCK_2, $trainingBlock2);
        $this->addReference(self::TRAINING_1_BLOCK_3, $trainingBlock3);
        $this->addReference(self::TRAINING_1_BLOCK_4, $trainingBlock4);
        $this->addReference(self::TRAINING_1_BLOCK_5, $trainingBlock5);
        $this->addReference(self::TRAINING_1_BLOCK_6, $trainingBlock6);
    }

    public function getDependencies()
    {
        return [
            UsersFixtures::class
        ];
    }
}
