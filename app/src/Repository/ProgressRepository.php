<?php

namespace App\Repository;

use App\Entity\Grade;
use App\Entity\Progress;
use App\Entity\Student;
use App\Entity\Teacher;
use App\Entity\Training;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Progress>
 *
 * @method Progress|null find($id, $lockMode = null, $lockVersion = null)
 * @method Progress|null findOneBy(array $criteria, array $orderBy = null)
 * @method Progress[]    findAll()
 * @method Progress[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProgressRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Progress::class);
    }

    public function findProgressForTeacherByStudent(Teacher $teacher, Student $student)
    {
        return $this->createQueryBuilder('p')
            ->join('p.student', 's')
            ->join('s.inscriptions', 'i')
            ->join('i.training', 't')
            ->where('s.id = :student')
            ->setParameter('student', $student)
            ->andWhere('t.teacher = :teacher')
            ->setParameter('teacher', $teacher)
            ->orderBy('s.lastname', 'ASC')
            ->addOrderBy('t.title', 'ASC')
            ->getQuery()
            ->getResult();
    }

    public function findProgressForTeacherByGrade(Teacher $teacher, Grade $grade)
    {
        return $this->createQueryBuilder('p')
            ->join('p.inscription', 'i')
            ->join('i.training', 't')
            ->join('i.grade', 'g')
            ->where('t.teacher = :teacher')
            ->andWhere('g.teacher = :teacher')
            ->setParameter('teacher', $teacher)
            ->andWhere('i.grade = :grade')
            ->setParameter(':grade', $grade)
            ->orderBy('i.training', 'ASC')
            ->addOrderBy('s.lastname', 'ASC')
            ->getQuery()
            ->getResult();
    }

    public function findProgressForTeacherByTraining(Teacher $teacher, Training $training)
    {
        return $this->createQueryBuilder('p')
            ->join('p.inscription', 'i')
            ->join('i.training', 't')
            ->where('t.teacher = :teacher')
            ->setParameter('teacher', $teacher)
            ->andWhere('i.training = :training')
            ->setParameter('training', $training)
            ->orderBy('t.title', 'ASC')
            ->addOrderBy('i.grade', 'ASC')
            ->getQuery()
            ->getResult();
    }
}
