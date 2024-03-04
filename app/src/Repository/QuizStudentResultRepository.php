<?php

namespace App\Repository;

use App\Entity\QuizStudentResult;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<QuizStudentResult>
 *
 * @method QuizStudentResult|null find($id, $lockMode = null, $lockVersion = null)
 * @method QuizStudentResult|null findOneBy(array $criteria, array $orderBy = null)
 * @method QuizStudentResult[]    findAll()
 * @method QuizStudentResult[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class QuizStudentResultRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, QuizStudentResult::class);
    }

    //    /**
    //     * @return QuizStudentResult[] Returns an array of QuizStudentResult objects
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

    //    public function findOneBySomeField($value): ?QuizStudentResult
    //    {
    //        return $this->createQueryBuilder('q')
    //            ->andWhere('q.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
