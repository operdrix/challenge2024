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

    public function getAllStudentAnswersByQuizId(int $quizId, int $studentId): array
    {
        return $this->createQueryBuilder('qsa')
            ->join('qsa.quizQuestion', 'qq')
            ->join('qq.quiz', 'q')
            ->join('qsa.student', 's')
            ->andWhere('s.id = :studentId')
            ->andWhere('q.id = :quizId')
            ->setParameter('studentId', $studentId)
            ->setParameter('quizId', $quizId)
            ->getQuery()
            ->getResult();
    }
}
