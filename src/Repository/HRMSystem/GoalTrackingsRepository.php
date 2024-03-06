<?php

namespace App\Repository\HRMSystem;

use App\Entity\HRMSystem\Performance\GoalTrackings;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<GoalTrackings>
 *
 * @method GoalTrackings|null find($id, $lockMode = null, $lockVersion = null)
 * @method GoalTrackings|null findOneBy(array $criteria, array $orderBy = null)
 * @method GoalTrackings[]    findAll()
 * @method GoalTrackings[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GoalTrackingsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, GoalTrackings::class);
    }

    public function save(GoalTrackings $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(GoalTrackings $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return GoalTrackings[] Returns an array of GoalTrackings objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('g')
//            ->andWhere('g.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('g.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?GoalTrackings
//    {
//        return $this->createQueryBuilder('g')
//            ->andWhere('g.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
