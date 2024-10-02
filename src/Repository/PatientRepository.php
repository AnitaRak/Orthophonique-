<?php

namespace App\Repository;

use App\Entity\Patient;
use App\Model\SearchData;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;

/**
 * @extends ServiceEntityRepository<Patient>
 *
 * @method Patient|null find($id, $lockMode = null, $lockVersion = null)
 * @method Patient|null findOneBy(array $criteria, array $orderBy = null)
 * @method Patient[]    findAll()
 * @method Patient[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PatientRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry, private PaginatorInterface $paginatorInterface)
    {
        parent::__construct($registry, Patient::class);
    }
    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Patient $entity, bool $flush = true): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }
    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function remove(Patient $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }


    //Recherche patient 
    public function findBySearch(SearchData $searchData): PaginationInterface
    {
        $queryBuilder = $this->createQueryBuilder('p')
            ->leftJoin('p.schoolGrade', 's')
            ->addSelect('s');

        if (!empty($searchData->q)) {
            $queryBuilder = $queryBuilder
                ->andWhere('p.name LIKE :q 
                            OR p.last_name LIKE :q 
                            OR p.gender LIKE :q 
                            OR s.name LIKE :q 
                            OR p.birth_date LIKE :q')
                ->setParameter('q', '%' . $searchData->q . '%');
        }

        // Ajouter l'ordre par date de création
        $queryBuilder = $queryBuilder->orderBy('p.created_at', 'DESC');

        $query = $queryBuilder->getQuery();

        return $this->paginatorInterface->paginate(
            $query,
            $searchData->page,
            5
        );
    }


    //    /**
    //     * @return Patient[] Returns an array of Patient objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('p.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Patient
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
