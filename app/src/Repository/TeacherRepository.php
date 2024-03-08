<?php

namespace App\Repository;

use App\Entity\Teacher;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Repository des profs
 *
 * @extends ServiceEntityRepository<Teacher>
 *
 * @method Teacher|null find($id, $lockMode = null, $lockVersion = null)
 * @method Teacher|null findOneBy(array $criteria, array $orderBy = null)
 * @method Teacher[]    findAll()
 * @method Teacher[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TeacherRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Teacher::class);
    }

    /**
     * Requête par défaut
     */
    public function getBaseQueryBuilder(array $filters = []): QueryBuilder
    {
        $queryBuilder = $this->createQueryBuilder("t");

        if (!empty($filters["firstname"])) {
            $queryBuilder->andWhere("t.firstname LIKE :firstname")
                ->setParameter("firstname", '%' . $filters["firstname"] . '%');
        }

        if (!empty($filters["lastname"])) {
            $queryBuilder->andWhere("t.lastname LIKE :lastname")
                ->setParameter("lastname", '%' . $filters["lastname"] . '%');
        }

        if (!empty($filters["email"])) {
            $queryBuilder->andWhere("t.email LIKE :email")
                ->setParameter("email", '%' . $filters["email"] . '%');
        }

        if (!empty($filters["student"])) {
            $queryBuilder->leftJoin("t.trainings", "training")
                ->leftJoin("training.inscriptions", "inscription")
                ->leftJoin("inscription.students", "student1");

            $queryBuilder->leftJoin("t.grades", "grade")
                ->leftJoin("grade.students", "student2");

            $queryBuilder->where("student1 = :student OR student2 = :student")
                ->setParameter("student", $filters["student"]);

        }

        return $queryBuilder;

    }
}
