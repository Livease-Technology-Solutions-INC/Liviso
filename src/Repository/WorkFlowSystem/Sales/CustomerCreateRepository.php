<?php

namespace App\Repository\WorkFlowSystem\Sales;

use App\Entity\WorkFlowSystem\Sales\CustomerCreate;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CustomerCreate>
 *
 * @method CustomerCreate|null find($id, $lockMode = null, $lockVersion = null)
 * @method CustomerCreate|null findOneBy(array $criteria, array $orderBy = null)
 * @method CustomerCreate[]    findAll()
 * @method CustomerCreate[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CustomerCreateRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CustomerCreate::class);
    }

    public function save(CustomerCreate $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(CustomerCreate $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return CustomerCreate[] Returns an array of CustomerCreate objects
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

//    public function findOneBySomeField($value): ?CustomerCreate
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
