<?php

namespace App\Repository;

use App\Entity\Student;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Repository des élèves
 *
 * @extends ServiceEntityRepository<Student>
 *
 * @method Student|null find($id, $lockMode = null, $lockVersion = null)
 * @method Student|null findOneBy(array $criteria, array $orderBy = null)
 * @method Student[]    findAll()
 * @method Student[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StudentRepository extends ServiceEntityRepository
{
    /**
     * Constructor
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Student::class);
    }

    /**
     * Requête de base
     */
    public function getBaseQueryBuilder(array $filters = []): QueryBuilder
    {
        $queryBuilder = $this->createQueryBuilder("s");

        if (!empty($filters["firstname"])) {
            $queryBuilder->andWhere("s.firstname LIKE :firstname")
                ->setParameter("firstname", '%' . $filters["firstname"] . '%');
        }

        if (!empty($filters["lastname"])) {
            $queryBuilder->andWhere("s.lastname LIKE :lastname")
                ->setParameter("lastname", '%' . $filters["lastname"] . '%');
        }

        if (!empty($filters["email"])) {
            $queryBuilder->andWhere("s.email LIKE :email")
                ->setParameter("email", '%' . $filters["email"] . '%');
        }

        return $queryBuilder;
    }

    public function getQuizByTrainingAndStudent($trainingId, $studentId)
    {
        $queryBuilder = $this->createQueryBuilder("s");
        $queryBuilder->join("s.inscriptions", "i");
        $queryBuilder->join("i.training", "t");
        $queryBuilder->join("t.quizzes", "q");
        $queryBuilder->andWhere("t.id = :trainingId")
            ->setParameter("trainingId", $trainingId);
        $queryBuilder->andWhere("s.id = :studentId")
            ->setParameter("studentId", $studentId);
        return $queryBuilder->getQuery()->getResult();
    }
}
