<?php

namespace App\Repository;

use App\Entity\TrainingObjective;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<TrainingObjective>
 *
 * @method TrainingObjective|null find($id, $lockMode = null, $lockVersion = null)
 * @method TrainingObjective|null findOneBy(array $criteria, array $orderBy = null)
 * @method TrainingObjective[]    findAll()
 * @method TrainingObjective[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TrainingObjectiveRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TrainingObjective::class);
    }

    //    /**
    //     * @return TrainingObjective[] Returns an array of TrainingObjective objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('t')
    //            ->andWhere('t.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('t.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?TrainingObjective
    //    {
    //        return $this->createQueryBuilder('t')
    //            ->andWhere('t.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
