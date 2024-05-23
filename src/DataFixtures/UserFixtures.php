<?php

namespace App\DataFixtures;

use App\Entity\Appauthorization;
use App\Entity\User;
use App\Entity\Profile;
use App\Entity\Appfunction;
use App\Entity\Appsubfunction;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\String\Slugger\SluggerInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{

    public const ADMIN = 'ADMIN_USER';

    public function __construct(
        private readonly UserPasswordHasherInterface $hasher,
        private readonly SluggerInterface $slugger
    )
    {
        
    }

    public function load(ObjectManager $manager): void
    {
        /**********************PROFIL ADMIN *************/
        $profileSuperAdmin= (new Profile());

        $profileSuperAdmin->setName('Super Administrateur')
                ->setDescription('Super Administrateur de l\'application')
                ->setSuperadmin(true)
                ->setUpdatedAt(\DateTimeImmutable::createFromMutable(new DateTime()))
                ->setCreatedAt(\DateTimeImmutable::createFromMutable(new DateTime()));

        $manager->persist($profileSuperAdmin);
        $manager->flush();
        
        /**********************PROFIL ADMIN *************/
        $profileAdmin= (new Profile());

        $profileAdmin->setName('Administrateur')
                ->setDescription('Administrateur de l\'application')
                ->setSuperadmin(false)
                ->setUpdatedAt(\DateTimeImmutable::createFromMutable(new DateTime()))
                ->setCreatedAt(\DateTimeImmutable::createFromMutable(new DateTime()));

        $manager->persist($profileAdmin);
        $manager->flush();
        /************************************************/


        $AppfunctionNames=[['Administration','gear-fill']];
        $Appsubfonctionnames['Administration']=['Fonctions','Profils','Autorisations par profil','Utilisateurs','Paramétres généraux'];
        
        foreach ($AppfunctionNames as $AppfunctionName ) {

            $Appfunction = (new Appfunction())
                    ->setName($AppfunctionName[0])
                    ->setIcon($AppfunctionName[1])
                    ->setUpdatedAt(\DateTimeImmutable::createFromMutable(new DateTime()))
                    ->setCreatedAt(\DateTimeImmutable::createFromMutable(new DateTime()));
            
            $manager->persist($Appfunction);
            $manager->flush();

            foreach ($Appsubfonctionnames[$AppfunctionName[0]] as $Appsubfonctionname ) {

                $Appsubfunction = (new Appsubfunction())
                ->setName($Appsubfonctionname)
                ->setSlug($this->slugger->slug(strtolower($Appsubfonctionname)))
                ->setAppfunction($Appfunction)
                ->setUpdatedAt(\DateTimeImmutable::createFromMutable(new DateTime()))
                ->setCreatedAt(\DateTimeImmutable::createFromMutable(new DateTime()));
        
                if ($Appsubfonctionname=='Fonctions') 
                $Appsubfunction->setSuperadmin(true);
                else $Appsubfunction->setSuperadmin(false);

                $manager->persist($Appsubfunction);
                $manager->flush();

                $profileSuperAdmin->addAppauthorization((new Appauthorization())
                ->setLevel('EDIT')
                ->setAppsubfunction($Appsubfunction));

            }

        }

        $user= (new User());
        $user->setRoles(['ROLE_ADMIN'])
             ->setEmail('contact.admin@wisedev.fr')
             ->setUsername('superadmin')
             ->setVerified(true)
             ->setUpdatedAt(\DateTimeImmutable::createFromMutable(new DateTime()))
             ->setCreatedAt(\DateTimeImmutable::createFromMutable(new DateTime()))
             ->setPassword($this->hasher->hashPassword($user,'admin'))
             ->setProfile($profileSuperAdmin);
             //->setApiToken('admin_token');

        $this->addReference(self::ADMIN, $user);
               
        $manager->persist($user);

        $profileUser= (new Profile());

        $profileUser->setName('Utilisateur standard')
                ->setDescription('Utilisateur standard de l\'application')
                ->setSuperadmin(false)
                ->setUpdatedAt(\DateTimeImmutable::createFromMutable(new DateTime()))
                ->setCreatedAt(\DateTimeImmutable::createFromMutable(new DateTime()));

        $manager->persist($profileUser);
        $manager->flush();

        /*for ($i=1 ;$i <=10; $i++) { 
           
            $user= (new User());
            $user->setRoles([])
                 ->setEmail("user$i@sfr.fr")
                 ->setUsername("user$i")
                 ->setUpdatedAt(\DateTimeImmutable::createFromMutable(new DateTime()))
                 ->setCreatedAt(\DateTimeImmutable::createFromMutable(new DateTime()))
                 ->setVerified(true)
                 ->setPassword($this->hasher->hashPassword($user,'0000'))
                 ->setProfile($profileUser);
                 //->setApiToken("user[$i]");

            $this->addReference('USER'.$i,$user);
            
            $manager->persist($user);
    
        }*/

        $manager->flush();

    }
}
