<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Users;

class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $admin = new Users();
        $admin->setNom("Nguyen");
        $admin->setPrenom("Thu Hang");
        $admin->setLogin("admin");
        $admin->setMdp('admin');
        $admin->setType("admin");

        $manager->persist($admin);

        $manager->flush();
    }
}
