<?php

namespace App\Repository;

use App\Entity\OptionResponse;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<OptionResponse>
 *
 * @method OptionResponse|null find($id, $lockMode = null, $lockVersion = null)
 * @method OptionResponse|null findOneBy(array $criteria, array $orderBy = null)
 * @method OptionResponse[]    findAll()
 * @method OptionResponse[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OptionResponseRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, OptionResponse::class);
    }

//    /**
//     * @return OptionResponse[] Returns an array of OptionResponse objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('o')
//            ->andWhere('o.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('o.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?OptionResponse
//    {
//        return $this->createQueryBuilder('o')
//            ->andWhere('o.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
