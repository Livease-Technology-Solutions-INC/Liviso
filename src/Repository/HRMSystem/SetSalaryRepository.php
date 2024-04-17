<?php

namespace App\Repository\HRMSystem;

use App\Entity\HRMSystem\PayrollSetup\Salary;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<SetSalary>
 *
 * @method SetSalary|null find($id, $lockMode = null, $lockVersion = null)
 * @method SetSalary|null findOneBy(array $criteria, array $orderBy = null)
 * @method SetSalary[]    findAll()
 * @method SetSalary[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SetSalaryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Salary::class);
    }

//    /**
//     * @return SetSalary[] Returns an array of SetSalary objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('s.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?SetSalary
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
