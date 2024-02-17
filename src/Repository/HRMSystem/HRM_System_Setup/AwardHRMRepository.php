<?php

namespace App\Repository\HRMSystem\HRM_System_Setup;

use App\Entity\HRMSystem\HRM_System_Setup\AwardHRM;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<AwardHRM>
 *
 * @method AwardHRM|null find($id, $lockMode = null, $lockVersion = null)
 * @method AwardHRM|null findOneBy(array $criteria, array $orderBy = null)
 * @method AwardHRM[]    findAll()
 * @method AwardHRM[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AwardHRMRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AwardHRM::class);
    }

    public function save(AwardHRM $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(AwardHRM $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return AwardHRM[] Returns an array of AwardHRM objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('a.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?AwardHRM
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
