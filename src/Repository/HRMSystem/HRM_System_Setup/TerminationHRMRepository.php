<?php

namespace App\Repository\HRMSystem\HRM_System_Setup;

use App\Entity\HRMSystem\HRM_System_Setup\TerminationHRM;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<TerminationHRM>
 *
 * @method TerminationHRM|null find($id, $lockMode = null, $lockVersion = null)
 * @method TerminationHRM|null findOneBy(array $criteria, array $orderBy = null)
 * @method TerminationHRM[]    findAll()
 * @method TerminationHRM[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TerminationHRMRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TerminationHRM::class);
    }

    public function save(TerminationHRM $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(TerminationHRM $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return TerminationHRM[] Returns an array of TerminationHRM objects
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

//    public function findOneBySomeField($value): ?TerminationHRM
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
