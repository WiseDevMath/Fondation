<?php

namespace App\Repository;

use App\Entity\Appsubfunction;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Appsubfunction>
 */
class AppsubfunctionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Appsubfunction::class);
    }

    public function findAllAuthorizations(): ?array  {

        return $this->createQueryBuilder('s')
        ->select('NEW App\\DTO\\AllAuthorizations(s.id,s.name,p.id,p.name,a.id,a.level) ')
        ->where('s.isSuperadmin=0')
        ->leftJoin('s.appauthorizations','a')
        ->leftJoin('a.profile','p')
        ->orderBy('s.name','ASC')
        ->getQuery()
        ->getResult();

    }

    public function findAllAppsubfunctions(): ?array {

        return $this->createQueryBuilder('s')->select('s')
        ->where('s.isSuperadmin=0')
        ->getQuery()
        ->getResult();

    }

    public function findOneById($id): ?Appsubfunction
        {
            return $this->createQueryBuilder('s')
                ->andWhere('s.id = :val')
                ->setParameter('val', $id)
                ->getQuery()
                ->getOneOrNullResult()
            ;
        }


    //    /**
    //     * @return Appsubfunction[] Returns an array of Appsubfunction objects
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

    //    public function findOneBySomeField($value): ?Appsubfunction
    //    {
    //        return $this->createQueryBuilder('a')
    //            ->andWhere('a.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
