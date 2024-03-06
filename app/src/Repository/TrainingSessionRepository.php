<?php

namespace App\Repository;

use App\Entity\Student;
use App\Entity\Teacher;
use App\Entity\TrainingSession;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<TrainingSession>
 *
 * @method TrainingSession|null find($id, $lockMode = null, $lockVersion = null)
 * @method TrainingSession|null findOneBy(array $criteria, array $orderBy = null)
 * @method TrainingSession[]    findAll()
 * @method TrainingSession[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TrainingSessionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TrainingSession::class);
    }

    public function findByStudent(Student $student, array $params)
    {
        return $this->createQueryBuilder('ts')
            ->join('ts.inscription', 'i')
            ->join('i.students', 's')
            ->where('s = :student')
            ->setParameter('student', $student)
            ->andWhere('ts.startDate >= :start')
            ->setParameter('start', $params['startDate'])
            ->andWhere('ts.startDate <= :end')
            ->setParameter('end', $params['endDate'])
            ->orderBy('ts.startDate')
            ->getQuery()
            ->getResult();
    }

    public function findByGrades(Student $student, array $params)
    {
        return $this->createQueryBuilder('ts')
            ->join('ts.inscription', 'i')
            ->join('i.grade', 'g')
            ->join('g.students', 's')
            ->where('s = :student')
            ->setParameter('student', $student)
            ->andWhere('ts.startDate >= :start')
            ->setParameter('start', $params['startDate'])
            ->andWhere('ts.endDate <= :end')
            ->setParameter('end', $params['endDate'])
            ->getQuery()
            ->getResult();
    }

    public function findByTeacher(Teacher $teacher, array $params)
    {
        return $this->createQueryBuilder('ts')
            ->join('ts.inscription', 'i')
            ->join('i.training', 't')
            ->where('t.teacher = :teacher')
            ->setParameter('teacher', $teacher)
            ->andWhere('ts.startDate >= :start')
            ->setParameter('start', $params['startDate'])
            ->andWhere('ts.startDate <= :end')
            ->setParameter('end', $params['endDate'])
            ->getQuery()
            ->getResult();
    }
}
