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
    public function getBaseQueryBuilder(array $filters, Teacher $teacher): QueryBuilder
    {
        $queryBuilder = $this->createQueryBuilder("t")
            ->andWhere("t.teacher = :teacher")
            ->setParameter("teacher", $teacher);

        if (!empty($filters["title"])) {
            $queryBuilder->andWhere("t.title LIKE :title")
                ->setParameter("title", '%' . $filters["title"] . '%');
        }

        if (!empty($filters["difficulty"])) {
            $queryBuilder->andWhere("t.difficulty = :difficulty")
                ->setParameter("difficulty", $filters["difficulty"]);
        }

        return $queryBuilder;
    }
}
