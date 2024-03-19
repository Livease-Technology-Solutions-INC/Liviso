<?php

namespace App\Repository\AccountingSystem;

use App\Entity\AccountingSystem\FinancialGoal;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<FinancialGoal>
 *
 * @method FinancialGoal|null find($id, $lockMode = null, $lockVersion = null)
 * @method FinancialGoal|null findOneBy(array $criteria, array $orderBy = null)
 * @method FinancialGoal[]    findAll()
 * @method FinancialGoal[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FinancialGoalRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FinancialGoal::class);
    }

    public function save(FinancialGoal $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(FinancialGoal $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return FinancialGoal[] Returns an array of FinancialGoal objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('f')
//            ->andWhere('f.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('f.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?FinancialGoal
//    {
//        return $this->createQueryBuilder('f')
//            ->andWhere('f.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
