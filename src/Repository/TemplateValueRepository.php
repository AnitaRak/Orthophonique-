<?php

namespace App\Repository;

use App\Entity\TemplateValue;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<TemplateValue>
 *
 * @method TemplateValue|null find($id, $lockMode = null, $lockVersion = null)
 * @method TemplateValue|null findOneBy(array $criteria, array $orderBy = null)
 * @method TemplateValue[]    findAll()
 * @method TemplateValue[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TemplateValueRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TemplateValue::class);
    }

//    /**
//     * @return TemplateValue[] Returns an array of TemplateValue objects
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

//    public function findOneBySomeField($value): ?TemplateValue
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
