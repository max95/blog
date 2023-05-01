<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\User;

class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $user = new User();
        $user->setUsername('Paul');
        $user->setPassword('$2y$13$CbK3eKDy7HGKyrQe.LJHG.Bv1E/zLSXzT0RquRTgAM51h4PSux0da');
        $manager->persist($user);

        $admin = new User();
        $admin->setUsername('Admin');
        $admin->setPassword('$2y$13$xnBS7nwq7Pon/y6E97ELkewLPeUDs7kUq4gQLc5CIOKssvlN/rz7m');
        $admin->setRoles(['ROLE_ADMIN']);
        $manager->persist($admin);

        
        $manager->flush();
    }
}
