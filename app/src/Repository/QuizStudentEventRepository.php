<?php

namespace App\Repository;

use App\Entity\QuizStudentEvent;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<QuizStudentEvent>
 *
 * @method QuizStudentEvent|null find($id, $lockMode = null, $lockVersion = null)
 * @method QuizStudentEvent|null findOneBy(array $criteria, array $orderBy = null)
 * @method QuizStudentEvent[]    findAll()
 * @method QuizStudentEvent[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class QuizStudentEventRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, QuizStudentEvent::class);
    }

    //    /**
    //     * @return QuizStudentEvent[] Returns an array of QuizStudentEvent objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('q')
    //            ->andWhere('q.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('q.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?QuizStudentEvent
    //    {
    //        return $this->createQueryBuilder('q')
    //            ->andWhere('q.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
