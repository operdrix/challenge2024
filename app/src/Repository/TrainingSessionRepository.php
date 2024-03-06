<?php

namespace App\Repository;

use App\Entity\Teacher;
use App\Entity\TrainingSession;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<TrainingSession>
 *
 * @method TrainingSession|null find($id, $lockMode = null, $lockVersion = null)
 * @method TrainingSession|null findOneBy(array $criteria, array $orderBy = null)
 * @method TrainingSession[]    findAll()
 * @method TrainingSession[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TrainingSessionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TrainingSession::class);
    }

    /**
     * Retourne les prochaines sessions de formation d'un formateur
     * Optionel : rajouter la date au plus tard pour la recherche
     * @param Teacher $teacher
     *
     * @return TrainingSession[]
     */
    public function findNextTrainingsSessions(Teacher $teacher): array
    {

        $qb = $this->createQueryBuilder('ts')
            ->join('ts.inscription', 'i')
            ->join('i.training', 't')
            ->join('t.teacher', 'te')
            ->where('te.id = :teacherId')
            ->andWhere('ts.startDate >= :now')
            ->andWhere('ts.startDate <= :end')
            ->setParameter('teacherId', $teacher->getId())
            ->setParameter('now', new \DateTime())
            ->setParameter('end', new \DateTime('+2 weeks'))
            ->orderBy('ts.startDate', 'ASC')
            ->getQuery()
        ;

        return $qb->getResult();
    }
}
