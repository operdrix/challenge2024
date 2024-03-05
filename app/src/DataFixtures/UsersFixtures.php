<?php

namespace App\DataFixtures;

use App\Entity\Admin;
use App\Entity\Student;
use App\Entity\Teacher;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UsersFixtures extends Fixture
{



    /**
     * Constructor
     */
    public function __construct(
        private readonly UserPasswordHasherInterface $passwordHasher
    ) {
    }

    public const ADMIN_1 = 'admin1';
    public const ADMIN_2 = 'admin2';
    public const TEACHER_1 = 'audrey';
    public const TEACHER_2 = 'cyril';
    public const STUDENT_1 = 'kenza';
    public const STUDENT_2 = 'olivier';
    public const STUDENT_3 = 'quentin';
    public const STUDENT_4 = 'arnaud';
    public const STUDENT_5 = 'loan';
    public const STUDENT_6 = 'mathis';

    public function load(ObjectManager $manager): void
    {
        // Création des administrateurs
        $admin1 = new Admin();
        $admin1->setFirstname("admin1");
        $admin1->setLastname("admin1");
        $admin1->setRoles(["ROLE_ADMIN"]);
        $admin1->setEmail("admin1@admin.fr");
        $admin1->setPassword($this->passwordHasher->hashPassword($admin1, "admin"));
        $admin1->setBirthdate(new \DateTimeImmutable());
        $admin1->setPhoneNumber("06 06 06 06 06");
        $manager->persist($admin1);

        $admin2 = new Admin();
        $admin2->setFirstname("admin2");
        $admin2->setLastname("admin2");
        $admin2->setRoles(["ROLE_ADMIN"]);
        $admin2->setEmail("admin2@admin.fr");
        $admin2->setPassword($this->passwordHasher->hashPassword($admin2, "admin"));
        $admin2->setBirthdate(new \DateTimeImmutable());
        $admin2->setPhoneNumber("06 06 06 06 06");
        $manager->persist($admin2);

        // Création des professeurs
        $audrey = new Teacher();
        $audrey->setFirstname("Audrey");
        $audrey->setLastname("Haussepian");
        $audrey->setEmail("audrey@teacher.fr");
        $audrey->setPassword($this->passwordHasher->hashPassword($audrey, "teacher"));
        $audrey->setBirthdate(new \DateTimeImmutable());
        $audrey->setPhoneNumber("06 06 06 06 06");
        $manager->persist($audrey);

        $cyril = new Teacher();
        $cyril->setFirstname("Cyril");
        $cyril->setLastname("Couffe");
        $cyril->setEmail("cyril@teacher.fr");
        $cyril->setPassword($this->passwordHasher->hashPassword($cyril, "teacher"));
        $cyril->setBirthdate(new \DateTimeImmutable());
        $cyril->setPhoneNumber("06 06 06 06 06");
        $manager->persist($cyril);

        // Création des étudiants
        $student1 = new Student();
        $student1->setFirstname("Kenza");
        $student1->setLastname("Schuler");
        $student1->setRoles(["ROLE_STUDENT"]);
        $student1->setEmail("kschuler@myges.fr");
        $student1->setPassword($this->passwordHasher->hashPassword($student1, "kschuler"));
        $student1->setBirthdate(new \DateTimeImmutable());
        $student1->setPhoneNumber("06 06 06 06 06");
        $manager->persist($student1);

        $student2 = new Student();
        $student2->setFirstname("Olivier");
        $student2->setLastname("Perdrix");
        $student2->setRoles(["ROLE_STUDENT"]);
        $student2->setEmail("operdrix@myges.fr");
        $student2->setPassword($this->passwordHasher->hashPassword($student2, "operdrix"));
        $student2->setBirthdate(new \DateTimeImmutable());
        $student2->setPhoneNumber("06 06 06 06 06");
        $manager->persist($student2);

        $student3 = new Student();
        $student3->setFirstname("Quentin");
        $student3->setLastname("Somveille");
        $student3->setRoles(["ROLE_STUDENT"]);
        $student3->setEmail("qsomveille@myges.fr");
        $student3->setPassword($this->passwordHasher->hashPassword($student3, "qsomveille"));
        $student3->setBirthdate(new \DateTimeImmutable());
        $student3->setPhoneNumber("06 06 06 06 06");
        $manager->persist($student3);

        $student4 = new Student();
        $student4->setFirstname("Arnaud");
        $student4->setLastname("Gouel");
        $student4->setRoles(["ROLE_STUDENT"]);
        $student4->setEmail("agouel@myges.fr");
        $student4->setPassword($this->passwordHasher->hashPassword($student4, "agouel"));
        $student4->setBirthdate(new \DateTimeImmutable());
        $student4->setPhoneNumber("06 06 06 06 06");
        $manager->persist($student4);

        $student5 = new Student();
        $student5->setFirstname("Loan");
        $student5->setLastname("Courchinoux-Billonnet");
        $student5->setRoles(["ROLE_STUDENT"]);
        $student5->setEmail("lcourchinouxbillonnet@myges.fr");
        $student5->setPassword($this->passwordHasher->hashPassword($student5, "lcourchinouxbillonnet"));
        $student5->setBirthdate(new \DateTimeImmutable());
        $student5->setPhoneNumber("06 06 06 06 06");
        $manager->persist($student5);

        $student6 = new Student();
        $student6->setFirstname("Mathis");
        $student6->setLastname("Rome");
        $student6->setRoles(["ROLE_STUDENT"]);
        $student6->setEmail("mrome@myges.fr");
        $student6->setPassword($this->passwordHasher->hashPassword($student6, "mrome"));
        $student6->setBirthdate(new \DateTimeImmutable());
        $student6->setPhoneNumber("06 06 06 06 06");
        $manager->persist($student6);

        $manager->flush();

        $this->addReference(self::ADMIN_1, $admin1);
        $this->addReference(self::ADMIN_2, $admin2);
        $this->addReference(self::TEACHER_1, $audrey);
        $this->addReference(self::TEACHER_2, $cyril);
        $this->addReference(self::STUDENT_1, $student1);
        $this->addReference(self::STUDENT_2, $student2);
        $this->addReference(self::STUDENT_3, $student3);
        $this->addReference(self::STUDENT_4, $student4);
        $this->addReference(self::STUDENT_5, $student5);
        $this->addReference(self::STUDENT_6, $student6);
    }
}
