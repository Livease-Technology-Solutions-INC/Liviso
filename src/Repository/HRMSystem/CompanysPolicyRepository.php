<?php

namespace App\Repository\HRMSystem;

use App\Entity\HRMSystem\CompanyPolicy;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CompanyPolicy>
 *
 * @method CompanyPolicy|null find($id, $lockMode = null, $lockVersion = null)
 * @method CompanyPolicy|null findOneBy(array $criteria, array $orderBy = null)
 * @method CompanyPolicy[]    findAll()
 * @method CompanyPolicy[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CompanysPolicyRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CompanyPolicy::class);
    }

//    /**
//     * @return CompanyPolicy[] Returns an array of CompanyPolicy objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('c.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?CompanyPolicy
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
