<?php

namespace App\DataFixtures;

use App\Entity\Grade;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class GradeFixtures extends Fixture implements DependentFixtureInterface
{
    /**
     * @var \Faker\Generator
     */
    private Generator $faker;

    /**
     * Constructor
     */
    public function __construct(
        private readonly UserPasswordHasherInterface $passwordHasher,
        private readonly EntityManagerInterface $entityManager
    ) {
        $this->faker = Factory::create('fr_FR');
    }

    public const TEACHER_1_SCHOOL_1_GRADE_1 = 'teacher1_school1_grade1';
    public const TEACHER_1_SCHOOL_2_GRADE_2 = 'teacher1_school2_grade2';
    public function load(ObjectManager $manager): void
    {
        $grade1 = new Grade();
        $grade1->setLabel("Classe 1");
        $grade1->setTeacher($this->getReference(UsersFixtures::TEACHER_1));
        $grade1->setSchool($this->getReference(SchoolFixtures::TEACHER_1_SCHOOL_1));
        $grade1->addStudent($this->getReference(UsersFixtures::STUDENT_1));
        $grade1->addStudent($this->getReference(UsersFixtures::STUDENT_2));
        $grade1->addStudent($this->getReference(UsersFixtures::STUDENT_3));
        $manager->persist($grade1);

        $grade2 = new Grade();
        $grade2->setLabel("Classe 2");
        $grade2->setTeacher($this->getReference(UsersFixtures::TEACHER_1));
        $grade2->setSchool($this->getReference(SchoolFixtures::TEACHER_1_SCHOOL_2));
        $grade2->addStudent($this->getReference(UsersFixtures::STUDENT_4));
        $grade2->addStudent($this->getReference(UsersFixtures::STUDENT_5));
        $grade2->addStudent($this->getReference(UsersFixtures::STUDENT_6));
        $manager->persist($grade2);

        $manager->flush();

        $this->addReference(self::TEACHER_1_SCHOOL_1_GRADE_1, $grade1);
        $this->addReference(self::TEACHER_1_SCHOOL_2_GRADE_2, $grade2);
    }

    public function getDependencies()
    {
        return [
            UsersFixtures::class,
            SchoolFixtures::class
        ];
    }
}
