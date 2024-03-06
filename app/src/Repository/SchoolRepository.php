<?php

namespace App\Repository;

use App\Entity\School;
use App\Entity\Teacher;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<School>
 *
 * @method School|null find($id, $lockMode = null, $lockVersion = null)
 * @method School|null findOneBy(array $criteria, array $orderBy = null)
 * @method School[]    findAll()
 * @method School[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SchoolRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, School::class);
    }

    /**
     * Requête par défaut
     */
    public function getBaseQueryBuilder(array $filters = [], Teacher $teacher): QueryBuilder
    {
        $queryBuilder = $this->createQueryBuilder("s");

        if (!empty($filters["name"])) {
            $queryBuilder->andWhere("s.name LIKE :name")
                ->setParameter("name", '%' . $filters["name"] . '%');
        }

        return $queryBuilder;

    }
}
