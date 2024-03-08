<?php

namespace App\Repository;

use App\Entity\QuizQuestionAvailableAnswer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<QuizQuestionAvailableAnswer>
 *
 * @method QuizQuestionAvailableAnswer|null find($id, $lockMode = null, $lockVersion = null)
 * @method QuizQuestionAvailableAnswer|null findOneBy(array $criteria, array $orderBy = null)
 * @method QuizQuestionAvailableAnswer[]    findAll()
 * @method QuizQuestionAvailableAnswer[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class QuizQuestionAvailableAnswerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, QuizQuestionAvailableAnswer::class);
    }

    //    /**
    //     * @return QuizQuestionAvailableAnswer[] Returns an array of QuizQuestionAvailableAnswer objects
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

    //    public function findOneBySomeField($value): ?QuizQuestionAvailableAnswer
    //    {
    //        return $this->createQueryBuilder('q')
    //            ->andWhere('q.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
