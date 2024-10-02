<?php

namespace App\Repository;

use App\Entity\TemplateQuestion;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<TemplateQuestion>
 *
 * @method TemplateQuestion|null find($id, $lockMode = null, $lockVersion = null)
 * @method TemplateQuestion|null findOneBy(array $criteria, array $orderBy = null)
 * @method TemplateQuestion[]    findAll()
 * @method TemplateQuestion[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TemplateQuestionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TemplateQuestion::class);
    }

//    /**
//     * @return TemplateQuestion[] Returns an array of TemplateQuestion objects
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

//    public function findOneBySomeField($value): ?TemplateQuestion
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
