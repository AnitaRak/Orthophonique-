<?php

namespace App\Repository;

use App\Model\SearchData;
use App\Entity\Evaluation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;

/**
 * @extends ServiceEntityRepository<Evaluation>
 *
 * @method Evaluation|null find($id, $lockMode = null, $lockVersion = null)
 * @method Evaluation|null findOneBy(array $criteria, array $orderBy = null)
 * @method Evaluation[]    findAll()
 * @method Evaluation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EvaluationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry, private PaginatorInterface $paginatorInterface)
    {
        parent::__construct($registry, Evaluation::class);
    }

    public function add(Evaluation $entity, bool $flush = true): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }
    public function findBySearch(SearchData $searchData): PaginationInterface
    {
        $queryBuilder = $this->createQueryBuilder('e')
            ->leftJoin('e.patient', 'p') //Jointure avec l'entité Patient.
            ->leftJoin('e.test', 't') //jointure avec entité test
            ->addSelect('p', 't')
            ->orderBy('e.created_at', 'DESC'); // Tri par date de création décroissante



        if (!empty($searchData->q)) {
            $queryBuilder = $queryBuilder
                ->andWhere('p.name LIKE :q OR p.last_name LIKE :q OR  t.name LIKE :q ')
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
    //     * @return Evaluation[] Returns an array of Evaluation objects
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

    //    public function findOneBySomeField($value): ?Evaluation
    //    {
    //        return $this->createQueryBuilder('e')
    //            ->andWhere('e.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
