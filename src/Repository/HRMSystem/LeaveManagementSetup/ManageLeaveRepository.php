<?php

namespace App\Repository\HRMSystem\LeaveManagementSetup;

use App\Entity\HRMSystem\LeaveManagementSetup\ManageLeave;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ManageLeave>
 *
 * @method ManageLeave|null find($id, $lockMode = null, $lockVersion = null)
 * @method ManageLeave|null findOneBy(array $criteria, array $orderBy = null)
 * @method ManageLeave[]    findAll()
 * @method ManageLeave[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ManageLeaveRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ManageLeave::class);
    }

    public function save(ManageLeave $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(ManageLeave $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return ManageLeave[] Returns an array of ManageLeave objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('m.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?ManageLeave
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
