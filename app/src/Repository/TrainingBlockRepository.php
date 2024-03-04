<?php

namespace App\Repository;

use App\Entity\TrainingBlock;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<TrainingBlock>
 *
 * @method TrainingBlock|null find($id, $lockMode = null, $lockVersion = null)
 * @method TrainingBlock|null findOneBy(array $criteria, array $orderBy = null)
 * @method TrainingBlock[]    findAll()
 * @method TrainingBlock[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TrainingBlockRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TrainingBlock::class);
    }

    //    /**
    //     * @return TrainingBlock[] Returns an array of TrainingBlock objects
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

    //    public function findOneBySomeField($value): ?TrainingBlock
    //    {
    //        return $this->createQueryBuilder('t')
    //            ->andWhere('t.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
