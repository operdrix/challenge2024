<?php

namespace App\DataFixtures;

use App\Entity\Admin;
use App\Entity\Student;
use App\Entity\Teacher;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

/**
 * Fixtures des applications
 */
class AppFixtures extends Fixture
{
    /**
     * Constructor
     */
    public function __construct(
        private readonly UserPasswordHasherInterface $passwordHasher
    )
    {
    }

    /**
     * Chargement des fixtures
     */
    public function load(ObjectManager $manager): void
    {
        $student = new Student();
        $student->setFirstname("Kenza");
        $student->setLastname("Schuler");
        $student->setRoles(["ROLE_STUDENT"]);
        $student->setEmail("kschuler@myges.fr");
        $student->setPassword($this->passwordHasher->hashPassword($student, "kschuler"));
        $student->setBirthdate(new \DateTimeImmutable());
        $student->setPhoneNumber("06 06 06 06 06");
        $manager->persist($student);

        $student = new Student();
        $student->setFirstname("Olivier");
        $student->setLastname("Perdrix");
        $student->setRoles(["ROLE_STUDENT"]);
        $student->setEmail("operdrix@myges.fr");
        $student->setPassword($this->passwordHasher->hashPassword($student, "operdrix"));
        $student->setBirthdate(new \DateTimeImmutable());
        $student->setPhoneNumber("06 06 06 06 06");
        $manager->persist($student);

        $student = new Student();
        $student->setFirstname("Quentin");
        $student->setLastname("Somveille");
        $student->setRoles(["ROLE_STUDENT"]);
        $student->setEmail("qsomveille@myges.fr");
        $student->setPassword($this->passwordHasher->hashPassword($student, "qsomveille"));
        $student->setBirthdate(new \DateTimeImmutable());
        $student->setPhoneNumber("06 06 06 06 06");
        $manager->persist($student);

        $student = new Student();
        $student->setFirstname("Arnaud");
        $student->setLastname("Gouel");
        $student->setRoles(["ROLE_STUDENT"]);
        $student->setEmail("agouel@myges.fr");
        $student->setPassword($this->passwordHasher->hashPassword($student, "agouel"));
        $student->setBirthdate(new \DateTimeImmutable());
        $student->setPhoneNumber("06 06 06 06 06");
        $manager->persist($student);

        $student = new Student();
        $student->setFirstname("Loan");
        $student->setLastname("Courchinoux-Billonnet");
        $student->setRoles(["ROLE_STUDENT"]);
        $student->setEmail("lcourchinouxbillonnet@myges.fr");
        $student->setPassword($this->passwordHasher->hashPassword($student, "lcourchinouxbillonnet"));
        $student->setBirthdate(new \DateTimeImmutable());
        $student->setPhoneNumber("06 06 06 06 06");
        $manager->persist($student);

        $student = new Student();
        $student->setFirstname("Mathis");
        $student->setLastname("Rome");
        $student->setRoles(["ROLE_STUDENT"]);
        $student->setEmail("mrome@myges.fr");
        $student->setPassword($this->passwordHasher->hashPassword($student, "mrome"));
        $student->setBirthdate(new \DateTimeImmutable());
        $student->setPhoneNumber("06 06 06 06 06");
        $manager->persist($student);

        $student = new Admin();
        $student->setFirstname("Administrateur");
        $student->setLastname("Administrateur");
        $student->setRoles(["ROLE_ADMIN"]);
        $student->setEmail("admin@admin.fr");
        $student->setPassword($this->passwordHasher->hashPassword($student, "admin"));
        $student->setBirthdate(new \DateTimeImmutable());
        $student->setPhoneNumber("06 06 06 06 06");
        $manager->persist($student);

        $student = new Teacher();
        $student->setFirstname("Doe");
        $student->setLastname("John");
        $student->setRoles(["ROLE_TEACHER"]);
        $student->setEmail("teacher@teacher.fr");
        $student->setPassword($this->passwordHasher->hashPassword($student, "teacher"));
        $student->setBirthdate(new \DateTimeImmutable());
        $student->setPhoneNumber("06 06 06 06 06");
        $manager->persist($student);

        $manager->flush();
    }
}
