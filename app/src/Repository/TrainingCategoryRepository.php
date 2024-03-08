<?php

namespace App\Repository;

use App\Entity\Teacher;
use App\Entity\TrainingCategory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<TrainingCategory>
 *
 * @method TrainingCategory|null find($id, $lockMode = null, $lockVersion = null)
 * @method TrainingCategory|null findOneBy(array $criteria, array $orderBy = null)
 * @method TrainingCategory[]    findAll()
 * @method TrainingCategory[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TrainingCategoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TrainingCategory::class);
    }

    /**
     * Requête de base
     */
    public function getBaseQueryBuilder(array $filters): QueryBuilder
    {
        $queryBuilder = $this->createQueryBuilder("tc");

        if (!empty($filters["teacher"])) {
            $queryBuilder->andWhere("tc.teacher = :teacher")
                ->setParameter("teacher", $filters["teacher"]);
        }

        if (!empty($filters["label"])) {
            $queryBuilder->andWhere("tc.label LIKE :label")
                ->setParameter("label", '%' . $filters["label"] . '%');
        }

        return $queryBuilder;
    }
}
