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
    public function getBaseQueryBuilder(array $filters): QueryBuilder
    {
        $queryBuilder = $this->createQueryBuilder("r");

        if (!empty($filters["teacher"])) {
            $queryBuilder->innerJoin("r.training", "t")
                ->andWhere("t.teacher = :teacher")
                ->setParameter("teacher", $filters["teacher"]);
        }

        if (!empty($filters["title"])) {
            $queryBuilder->andWhere("r.title LIKE :title")
                ->setParameter("title", '%' . $filters["title"] . '%');
        }

        return $queryBuilder;
    }
}
