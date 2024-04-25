<?php

namespace App\Repository\HRMSystem;

use App\Entity\HRMSystem\DocumentSetup;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<DocumentSetup>
 *
 * @method DocumentSetup|null find($id, $lockMode = null, $lockVersion = null)
 * @method DocumentSetup|null findOneBy(array $criteria, array $orderBy = null)
 * @method DocumentSetup[]    findAll()
 * @method DocumentSetup[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DocumentSetupRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DocumentSetup::class);
    }

//    /**
//     * @return DocumentSetup[] Returns an array of DocumentSetup objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('d')
//            ->andWhere('d.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('d.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?DocumentSetup
//    {
//        return $this->createQueryBuilder('d')
//            ->andWhere('d.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
