<?php

namespace App\DataFixtures;

use App\Entity\School;
use com_exception;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class SchoolFixtures extends Fixture  implements DependentFixtureInterface
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

    public const TEACHER_1_SCHOOL_1 = 'teacher1_school1';
    public const TEACHER_1_SCHOOL_2 = 'teacher1_school2';

    public function load(ObjectManager $manager): void
    {
        // Ajout des écoles

        $school1 = new School();
        $school1->setName($this->faker->company);
        $school1->setAddress($this->faker->address);
        $school1->setPhoneNumber($this->faker->phoneNumber);
        $school1->setContactName($this->faker->name);
        $school1->setEmail($this->faker->email);
        $school1->setTeacher($this->getReference(UsersFixtures::TEACHER_1));
        $manager->persist($school1);

        $school2 = new School();
        $school2->setName($this->faker->company);
        $school2->setAddress($this->faker->address);
        $school2->setPhoneNumber($this->faker->phoneNumber);
        $school2->setContactName($this->faker->name);
        $school2->setEmail($this->faker->email);
        $school2->setTeacher($this->getReference(UsersFixtures::TEACHER_1));
        $manager->persist($school2);

        for ($i = 0; $i < 5; $i++) {
            $school = new School();
            $school->setName($this->faker->company);
            $school->setAddress($this->faker->address);
            $school->setPhoneNumber($this->faker->phoneNumber);
            $school->setContactName($this->faker->name);
            $school->setEmail($this->faker->email);
            $school->setTeacher($this->getReference(UsersFixtures::TEACHER_1));
            $manager->persist($school);
        }

        for ($i = 0; $i < 5; $i++) {
            $school = new School();
            $school->setName($this->faker->company);
            $school->setAddress($this->faker->address);
            $school->setPhoneNumber($this->faker->phoneNumber);
            $school->setContactName($this->faker->name);
            $school->setEmail($this->faker->email);
            $school->setTeacher($this->getReference(UsersFixtures::TEACHER_2));
            $manager->persist($school);
        }

        $manager->flush();

        $this->addReference(self::TEACHER_1_SCHOOL_1, $school1);
        $this->addReference(self::TEACHER_1_SCHOOL_2, $school2);
    }

    public function getDependencies()
    {
        return [
            UsersFixtures::class,
        ];
    }
}
