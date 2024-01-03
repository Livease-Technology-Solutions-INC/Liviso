<?php

namespace App\Repository;

use App\Entity\RequiredBusinessCredentials;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<RequiredBusinessCredentials>
 *
 * @method RequiredBusinessCredentials|null find($id, $lockMode = null, $lockVersion = null)
 * @method RequiredBusinessCredentials|null findOneBy(array $criteria, array $orderBy = null)
 * @method RequiredBusinessCredentials[]    findAll()
 * @method RequiredBusinessCredentials[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RequiredBusinessCredentialsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RequiredBusinessCredentials::class);
    }

    public function save(RequiredBusinessCredentials $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(RequiredBusinessCredentials $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return RequiredBusinessCredentials[] Returns an array of RequiredBusinessCredentials objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('r.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?RequiredBusinessCredentials
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
