<?php

namespace App\Repository;

use App\Entity\Appauthorization;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Appauthorization>
 */
class AppauthorizationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Appauthorization::class);
    }

    public function findOneByProfileIdAndAppsubfunctionId($profile,$appsubfunction): ?Appauthorization
    {
        
        return $this->createQueryBuilder('s')
        ->andWhere('s.profile= :profile')
        ->andWhere('s.appsubfunction = :appsubfunction')
        ->setParameter('profile', $profile)
        ->setParameter('appsubfunction', $appsubfunction)
        ->getQuery()
        ->getOneOrNullResult();

    }      

    //    /**
    //     * @return Appauthorization[] Returns an array of Appauthorization objects
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

    //    public function findOneBySomeField($value): ?Appauthorization
    //    {
    //        return $this->createQueryBuilder('a')
    //            ->andWhere('a.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
