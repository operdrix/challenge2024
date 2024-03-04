<?php

namespace App\Repository;

use App\Entity\QuizQuestionStudentAnswer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<QuizQuestionStudentAnswer>
 *
 * @method QuizQuestionStudentAnswer|null find($id, $lockMode = null, $lockVersion = null)
 * @method QuizQuestionStudentAnswer|null findOneBy(array $criteria, array $orderBy = null)
 * @method QuizQuestionStudentAnswer[]    findAll()
 * @method QuizQuestionStudentAnswer[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class QuizQuestionStudentAnswerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, QuizQuestionStudentAnswer::class);
    }

    //    /**
    //     * @return QuizQuestionStudentAnswer[] Returns an array of QuizQuestionStudentAnswer objects
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

    //    public function findOneBySomeField($value): ?QuizQuestionStudentAnswer
    //    {
    //        return $this->createQueryBuilder('q')
    //            ->andWhere('q.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
