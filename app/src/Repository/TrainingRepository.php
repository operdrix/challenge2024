<?php

namespace App\Repository;

use App\Entity\Teacher;
use App\Entity\Training;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Training>
 *
 * @method Training|null find($id, $lockMode = null, $lockVersion = null)
 * @method Training|null findOneBy(array $criteria, array $orderBy = null)
 * @method Training[]    findAll()
 * @method Training[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TrainingRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Training::class);
    }

    /**
     * Requête de base
     */
    public function getBaseQueryBuilder(array $filters): QueryBuilder
    {
        $queryBuilder = $this->createQueryBuilder("t");

        if (!empty($filters["teacher"])) {
            $queryBuilder->andWhere("t.teacher = :teacher")
                ->setParameter("teacher", $filters["teacher"]);
        }

        if (!empty($filters["student"])) {
            $queryBuilder->leftJoin("t.inscriptions", "inscription")
                ->leftJoin("inscription.students", "student1")
                ->leftJoin("inscription.grade", "grade")
                ->leftJoin("grade.students", "student2")
                ->where("student1 = :student OR student2 = :student")
                ->setParameter("student", $filters["student"]);
        }

        if (!empty($filters["title"])) {
            $queryBuilder->andWhere("t.title LIKE :title")
                ->setParameter("title", '%' . $filters["title"] . '%');
        }

        if (!empty($filters["difficulty"])) {
            $queryBuilder->andWhere("t.difficulty = :difficulty")
                ->setParameter("difficulty", $filters["difficulty"]);
        }

        if (!empty($filters["length"])) {
            $queryBuilder->andWhere("t.length = :length")
                ->setParameter("length", $filters["length"]);
        }

        return $queryBuilder;
    }
}
