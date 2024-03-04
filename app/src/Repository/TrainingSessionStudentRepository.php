<?php

namespace App\Repository;

use App\Entity\TrainingSessionStudent;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<TrainingSessionStudent>
 *
 * @method TrainingSessionStudent|null find($id, $lockMode = null, $lockVersion = null)
 * @method TrainingSessionStudent|null findOneBy(array $criteria, array $orderBy = null)
 * @method TrainingSessionStudent[]    findAll()
 * @method TrainingSessionStudent[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TrainingSessionStudentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TrainingSessionStudent::class);
    }

    //    /**
    //     * @return TrainingSessionStudent[] Returns an array of TrainingSessionStudent objects
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

    //    public function findOneBySomeField($value): ?TrainingSessionStudent
    //    {
    //        return $this->createQueryBuilder('t')
    //            ->andWhere('t.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
