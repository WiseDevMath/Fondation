<?php

namespace App\Repository;

use App\Entity\User;
use App\DTO\AppFunctionSubFunction;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\PaginatorInterface;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

/**
 * @extends ServiceEntityRepository<User>
 */
class UserRepository extends ServiceEntityRepository implements PasswordUpgraderInterface
{
    public function __construct(ManagerRegistry $registry, private PaginatorInterface $paginator)
    {
        parent::__construct($registry, User::class);
    }

    /**
     * Used to upgrade (rehash) the user's password automatically over time.
     */
    public function upgradePassword(PasswordAuthenticatedUserInterface $user, string $newHashedPassword): void
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', $user::class));
        }

        $user->setPassword($newHashedPassword);
        $this->getEntityManager()->persist($user);
        $this->getEntityManager()->flush();
    }

    public function findUserByEmailOrUsername(string $usernameOrEmail): ?User  {

        return $this->createQueryBuilder('u')
            ->where('u.email = :identifier or u.username = :identifier')
            ->andWhere('u.isVerified = true')
            ->setParameter('identifier',$usernameOrEmail)
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();

    }

    public function findAuthorizations(int $userid): ?array  {

        return $this->createQueryBuilder('u')
        ->select('NEW App\\DTO\\AppFunctionSubFunction(f.id, f.icon,  f.name, s.id, s.slug, s.name,a.level) ')
        ->where('u.id = :userid')
        ->leftJoin('u.profile','p')
        ->leftJoin('p.appauthorizations','a')
        ->leftJoin('a.appsubfunction','s')
        ->leftJoin('s.Appfunction','f')
        ->setParameter('userid',$userid)
        ->orderBy('f.name','ASC')
        ->addOrderBy('s.name','ASC')
        ->getQuery()
        ->getResult();


    }

    public function findAuthorizationByUserAndSubFunction(int $userid,int $subfunctionid): ?AppFunctionSubFunction  {

        return $this->createQueryBuilder('u')
        ->select('NEW App\\DTO\\AppFunctionSubFunction(f.id, f.icon,  f.name, s.id, s.slug, s.name,a.level) ')
        ->where('u.id = :userid')
        ->andWhere('s.id = :subfunctionid')
        ->leftJoin('u.profile','p')
        ->leftJoin('p.appauthorizations','a')
        ->leftJoin('a.appsubfunction','s')
        ->leftJoin('s.Appfunction','f')
        ->setParameter('userid',$userid)
        ->setParameter('subfunctionid',$subfunctionid)
        ->orderBy('f.name','ASC')
        ->addOrderBy('s.name','ASC')
        ->getQuery()
        ->getOneOrNullResult();


    }

    public function paginatedUsers(int $page):PaginationInterface {

        $builder=$this->createQueryBuilder('u')->select('u','p')->leftJoin('u.profile','p');
        return $this->paginator->paginate(
            $builder,
            $page,
            5,
            [
                'distinct' => false,
                'sortFieldAllowList', ['u.id','u.username']
            ]
        );
    }

    //    /**
    //     * @return User[] Returns an array of User objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('u')
    //            ->andWhere('u.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('u.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?User
    //    {
    //        return $this->createQueryBuilder('u')
    //            ->andWhere('u.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
