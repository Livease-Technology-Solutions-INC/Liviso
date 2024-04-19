<?php

namespace App\Repository\HRMSystem;

use App\Entity\HRMSystem\PayrollSetup\PaySlips;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<PaySlips>
 *
 * @method PaySlips|null find($id, $lockMode = null, $lockVersion = null)
 * @method PaySlips|null findOneBy(array $criteria, array $orderBy = null)
 * @method PaySlips[]    findAll()
 * @method PaySlips[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PaySlipRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PaySlips::class);
    }

//    /**
//     * @return PaySlips[] Returns an array of PaySlips objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('p.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?PaySlips
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
