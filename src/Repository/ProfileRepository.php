<?php

namespace App\Repository;

use App\Entity\Profile;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\PaginatorInterface;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<Profile>
 */
class ProfileRepository extends ServiceEntityRepository
{
    
    public function __construct(ManagerRegistry $registry, private PaginatorInterface $paginator)
    {
        parent::__construct($registry, Profile::class);
    }

    public function paginatedProfiles(int $page):PaginationInterface {

        $builder=$this->createQueryBuilder('p')->select('p')->where('p.isSuperadmin=0');
        return $this->paginator->paginate(
            $builder,
            $page,
            5,
            [
                'distinct' => false,
                'sortFieldAllowList', ['p.id','p.name']
            ]
        );
    }

    public function findAllProfiles(): ?array {

        return $this->createQueryBuilder('p')->select('p')
        ->where('p.isSuperadmin=0')
        ->getQuery()
        ->getResult();

    }

    public function findOneById($id): ?Profile
        {
            return $this->createQueryBuilder('p')
                ->andWhere('p.id = :val')
                ->setParameter('val', $id)
                ->getQuery()
                ->getOneOrNullResult()
            ;
        }

    //    /**
    //     * @return Profile[] Returns an array of Profile objects
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

    //    public function findOneBySomeField($value): ?Profile
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
