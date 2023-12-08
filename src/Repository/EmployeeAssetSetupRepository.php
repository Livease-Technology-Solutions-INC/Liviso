<?php

namespace App\Repository;

use App\Entity\EmployeeAssetSetup;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<EmployeeAssetSetup>
 *
 * @method EmployeeAssetSetup|null find($id, $lockMode = null, $lockVersion = null)
 * @method EmployeeAssetSetup|null findOneBy(array $criteria, array $orderBy = null)
 * @method EmployeeAssetSetup[]    findAll()
 * @method EmployeeAssetSetup[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EmployeeAssetSetupRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EmployeeAssetSetup::class);
    }

    public function save(EmployeeAssetSetup $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(EmployeeAssetSetup $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return EmployeeAssetSetup[] Returns an array of EmployeeAssetSetup objects
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

//    public function findOneBySomeField($value): ?EmployeeAssetSetup
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
