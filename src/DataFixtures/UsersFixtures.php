<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\String\Slugger\SluggerInterface;



class UsersFixtures extends Fixture
{

    public function __construct(private UserPasswordHasherInterface $passwordEncoder,private SluggerInterface $sluger ){


    }
    public function load(ObjectManager $manager): void
    {
        //Création d'un utilisateur Admin
        $admin = new User();
        $admin->setNoAdeli('0000000');
        $admin->setEmail('admin@demo.fr');
        $admin->setLastName('Bériche');
        $admin->setName('Chln');
        $admin->setAddress('7 Rue jean Moulin');
        $admin->setZipcode('97440');
        $admin->setCity('Saint denis');
        $admin->setStatus('null');
        $admin->setPassword(
            $this->passwordEncoder->hashPassword($admin, 'admin')
        );
        $admin->setRoles(['ROLE_ADMIN']);
        $admin->setResetToken('123131531');

        $manager->persist($admin);
        $manager->flush();
    }
}
