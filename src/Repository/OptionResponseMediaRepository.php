<?php

namespace App\Repository;

use App\Entity\OptionResponseMedia;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<OptionResponseMedia>
 *
 * @method OptionResponseMedia|null find($id, $lockMode = null, $lockVersion = null)
 * @method OptionResponseMedia|null findOneBy(array $criteria, array $orderBy = null)
 * @method OptionResponseMedia[]    findAll()
 * @method OptionResponseMedia[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OptionResponseMediaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, OptionResponseMedia::class);
    }

//    /**
//     * @return OptionResponseMedia[] Returns an array of OptionResponseMedia objects
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

//    public function findOneBySomeField($value): ?OptionResponseMedia
//    {
//        return $this->createQueryBuilder('o')
//            ->andWhere('o.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
