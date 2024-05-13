<?php

namespace App\Repository;

use App\Entity\Appfunction;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\PaginatorInterface;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<Appfunction>
 */
class AppfunctionRepository extends ServiceEntityRepository
{
    
    public function __construct(ManagerRegistry $registry, private PaginatorInterface $paginator)
    {
        parent::__construct($registry, Appfunction::class);
    }

    public function paginatedAppfunctions(int $page):PaginationInterface {

        $builder=$this->createQueryBuilder('f')->select('f');
        return $this->paginator->paginate(
            $builder,
            $page,
            5,
            [
                'distinct' => false,
                'sortFieldAllowList', ['f.id','f.name']
            ]
        );
    }

    //    /**
    //     * @return Appfunction[] Returns an array of Appfunction objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('a')
    //            ->andWhere('a.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('a.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

        public function findOneById($id): ?Appfunction
        {
            return $this->createQueryBuilder('f')
                ->andWhere('f.id = :id')
                ->setParameter('id', $id)
                ->getQuery()
                ->getOneOrNullResult()
            ;
        }

}
