<?php

namespace App\Repository;

use App\Entity\Quiz;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Quiz>
 *
 * @method Quiz|null find($id, $lockMode = null, $lockVersion = null)
 * @method Quiz|null findOneBy(array $criteria, array $orderBy = null)
 * @method Quiz[]    findAll()
 * @method Quiz[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class QuizRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Quiz::class);
    }

    public function getBaseQueryBuilder(array $filters = []): QueryBuilder
    {
        $queryBuilder = $this->createQueryBuilder("q");

        if (!empty($filters["label"])) {
            $queryBuilder->andWhere("q.label LIKE :label")
                ->setParameter("label", '%' . $filters["label"] . '%');
        }
        if (!empty($filters["teacher"])) {
            $queryBuilder->join("q.training", "t")
                ->andWhere("t.teacher = :teacher")
                ->setParameter("teacher" ,$filters["teacher"]);
        }
        if (!empty($filters["training"])) {
            $queryBuilder->join("q.training", "t");
            $queryBuilder->andWhere("t.title LIKE :training")
                ->setParameter("training", '%' . $filters["training"] . '%');
        }

        return $queryBuilder;

    }

    public function getTotalPoints(Quiz $quiz): int
    {
        $queryBuilder = $this->createQueryBuilder("q");
        $queryBuilder->select("SUM(qq.point)")
            ->join("q.quizQuestions", "qq")
            ->where("q.id = :quizId")
            ->setParameter("quizId", $quiz->getId());

        return (int) $queryBuilder->getQuery()->getSingleScalarResult();
    }
}
