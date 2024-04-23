<?php

namespace App\Repository\HRMSystem\LeaveManagementSetup\Attendance;

use App\Entity\HRMSystem\LeaveManagementSetup\Attendance\BulkAttendance;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<BulkAttendance>
 *
 * @method BulkAttendance|null find($id, $lockMode = null, $lockVersion = null)
 * @method BulkAttendance|null findOneBy(array $criteria, array $orderBy = null)
 * @method BulkAttendance[]    findAll()
 * @method BulkAttendance[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BulkAttendanceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BulkAttendance::class);
    }

//    /**
//     * @return BulkAttendance[] Returns an array of BulkAttendance objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('b')
//            ->andWhere('b.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('b.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?BulkAttendance
//    {
//        return $this->createQueryBuilder('b')
//            ->andWhere('b.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
