<?php

namespace App\Repository\WorkFlowSystem\Sales;

use App\Entity\WorkFlowSystem\Sales\EnquiryCreation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<EnquiryCreation>
 *
 * @method EnquiryCreation|null find($id, $lockMode = null, $lockVersion = null)
 * @method EnquiryCreation|null findOneBy(array $criteria, array $orderBy = null)
 * @method EnquiryCreation[]    findAll()
 * @method EnquiryCreation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EnquiryCreationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EnquiryCreation::class);
    }

    public function save(EnquiryCreation $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(EnquiryCreation $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return EnquiryCreation[] Returns an array of EnquiryCreation objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('e.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?EnquiryCreation
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
