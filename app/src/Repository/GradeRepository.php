<?php

namespace App\Repository;

use App\Entity\Grade;
use App\Entity\Teacher;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Grade>
 *
 * @method Grade|null find($id, $lockMode = null, $lockVersion = null)
 * @method Grade|null findOneBy(array $criteria, array $orderBy = null)
 * @method Grade[]    findAll()
 * @method Grade[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GradeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Grade::class);
    }

    /**
     * Recherche des classes liées à un teacher
     *
     * @param Teacher $teacher
     */
    public function findGradesByTeacher(Teacher $teacher): array
    {
        return $this->createQueryBuilder('g')
            ->join('g.teacher', 't')
            ->where('t.id = :teacher')
            ->setParameter('teacher', $teacher->getId())
            ->getQuery()
            ->getResult();
    }

    /**
     * Requête de base
     */
    public function getBaseQueryBuilder(array $filters): QueryBuilder
    {
        $queryBuilder = $this->createQueryBuilder("g");

        if (!empty($filters["teacher"])) {
            $queryBuilder->andWhere("g.teacher = :teacher")
                ->setParameter("teacher", $filters["teacher"]);
        }
        if (!empty($filters["school"])) {
            $queryBuilder->andWhere("g.school = :school")
                ->setParameter("school", $filters["school"]);
        }

        if (!empty($filters["label"])) {
            $queryBuilder->andWhere("g.label LIKE :label")
                ->setParameter("label", '%' . $filters["label"] . '%');
        }

        if (!empty($filters["difficulty"])) {
            $queryBuilder->andWhere("g.difficulty = :difficulty")
                ->setParameter("difficulty", $filters["difficulty"]);
        }

        return $queryBuilder;
    }
}
