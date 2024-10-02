<?php

namespace App\Repository;

use App\Entity\SchoolGrade;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<SchoolGrade>
 *
 * @method SchoolGrade|null find($id, $lockMode = null, $lockVersion = null)
 * @method SchoolGrade|null findOneBy(array $criteria, array $orderBy = null)
 * @method SchoolGrade[]    findAll()
 * @method SchoolGrade[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SchoolGradeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SchoolGrade::class);
    }

//    /**
//     * @return SchoolGrade[] Returns an array of SchoolGrade objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('s.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?SchoolGrade
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
