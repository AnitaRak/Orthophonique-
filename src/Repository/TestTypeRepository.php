<?php

namespace App\Repository;

use App\Entity\TestType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<TestType>
 *
 * @method TestType|null find($id, $lockMode = null, $lockVersion = null)
 * @method TestType|null findOneBy(array $criteria, array $orderBy = null)
 * @method TestType[]    findAll()
 * @method TestType[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TestTypeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TestType::class);
    }

//    /**
//     * @return TestType[] Returns an array of TestType objects
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

//    public function findOneBySomeField($value): ?TestType
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
