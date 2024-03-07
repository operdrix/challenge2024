<?php

namespace App\Repository;

use App\Entity\Inscription;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Inscription>
 *
 * @method Inscription|null find($id, $lockMode = null, $lockVersion = null)
 * @method Inscription|null findOneBy(array $criteria, array $orderBy = null)
 * @method Inscription[]    findAll()
 * @method Inscription[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class InscriptionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Inscription::class);
    }


    public function findByStudentAndQuiz($studentId, $quizId)
    {
        return $this->createQueryBuilder('i')
            ->join('i.students', 's')
            ->join('i.training', 't')
            ->join('t.quizzes', 'q')
            ->where('s.id = :studentId')
            ->andWhere('q.id = :quizId')
            ->setParameter('studentId', $studentId)
            ->setParameter('quizId', $quizId)
            ->getQuery()
            ->getOneOrNullResult();
    }

    /**
     * Requête de base
     */
    public function getBaseQueryBuilder(array $filters): QueryBuilder
    {
        $queryBuilder = $this->createQueryBuilder("i");

        if (!empty($filters["teacher"])) {
            $queryBuilder->join("i.training", "t")
                ->andWhere("t.teacher = :teacher")
                ->setParameter("teacher", $filters["teacher"]);
        }

        if (!empty($filters["training"])) {
            $queryBuilder->andWhere("i.training = :training")
                ->setParameter("training", $filters["training"]);
        }

        if (!empty($filters["student"])) {
            $queryBuilder->leftJoin("i.students", "s")
                ->leftJoin("i.grade", "grade")
                ->leftJoin("grade.students", "students")
                ->where("s = :student OR students = :student")
            ->setParameter("student", $filters["student"]);
        }

        return $queryBuilder;
    }

}
