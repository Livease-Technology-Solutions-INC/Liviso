<?php

namespace App\Repository\HRMSystem;

use App\Entity\HRMSystem\EmployeesAssetSetup;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<EmployeesAssetSetup>
 *
 * @method EmployeesAssetSetup|null find($id, $lockMode = null, $lockVersion = null)
 * @method EmployeesAssetSetup|null findOneBy(array $criteria, array $orderBy = null)
 * @method EmployeesAssetSetup[]    findAll()
 * @method EmployeesAssetSetup[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EmployeeAssetSetupRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EmployeesAssetSetup::class);
    }

    public function save(EmployeesAssetSetup $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(EmployeesAssetSetup $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return EmployeesAssetSetup[] Returns an array of EmployeesAssetSetup objects
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

//    public function findOneBySomeField($value): ?EmployeesAssetSetup
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
