<?php

namespace App\Repository;


use App\Entity\Test;
use App\Model\SearchData;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;

/**
 * @extends ServiceEntityRepository<Test>
 *
 * @method Test|null find($id, $lockMode = null, $lockVersion = null)
 * @method Test|null findOneBy(array $criteria, array $orderBy = null)
 * @method Test[]    findAll()
 * @method Test[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TestRepository extends ServiceEntityRepository
{

    public function __construct(ManagerRegistry $registry, private PaginatorInterface $paginatorInterface)
    {



        parent::__construct($registry, Test::class);
    }


    public function findBySearch(SearchData $searchData): PaginationInterface
    {
        $queryBuilder = $this->createQueryBuilder('p')
            ->leftJoin('p.typeTest', 't')
            ->addSelect('t');

        if (!empty($searchData->q)) {
            $queryBuilder = $queryBuilder
                ->andWhere('p.name LIKE :q OR t.name LIKE :q')
                ->setParameter('q', '%' . $searchData->q . '%');
        }



        $query = $queryBuilder->getQuery();

        return $this->paginatorInterface->paginate(
            $query,
            $searchData->page,
            5
        );
    }



    //    /**
    //     * @return Test[] Returns an array of Test objects
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

    //    public function findOneBySomeField($value): ?Test
    //    {
    //        return $this->createQueryBuilder('t')
    //            ->andWhere('t.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
