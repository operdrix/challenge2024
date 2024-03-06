<?php

namespace App\Repository;

use App\Entity\Resource;
use App\Entity\Teacher;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Resource>
 *
 * @method resource|null find($id, $lockMode = null, $lockVersion = null)
 * @method resource|null findOneBy(array $criteria, array $orderBy = null)
 * @method resource[]    findAll()
 * @method resource[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ResourceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Resource::class);
    }

    /**
     * Requête de base
     */
    public function getBaseQueryBuilder(array $filters, Teacher $teacher): QueryBuilder
    {
        $queryBuilder = $this->createQueryBuilder("r")
            ->innerJoin("r.training", "t")
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
