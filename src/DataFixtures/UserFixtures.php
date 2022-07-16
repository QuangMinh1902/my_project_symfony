<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    private $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        $plaintextPassword = "admin";
        $admin1 = new User();
        $admin1->setEmail('admin1@gmail.com');
        $hashedPassword =$this->passwordHasher->hashPassword(
            $admin1,
            $plaintextPassword
        );
        $admin1->setPassword($hashedPassword);
        $admin1->setRoles(['ROLE_ADMIN']);
        $admin2 = new User();
        $admin2->setEmail('admin2@gmail.com');
        $hashedPassword =$this->passwordHasher->hashPassword(
            $admin2,
            $plaintextPassword
        );
        $admin2->setPassword($hashedPassword);
        $admin2->setRoles(['ROLE_ADMIN']);
        $manager->persist($admin1);
        $manager->persist($admin2);
        $plaintextPassword = "user";
        for ($i = 1; $i <= 5; $i++) {
            $user = new User();
            $user->setEmail("user$i@gmail.com");
            $hashedPassword = $this->passwordHasher->hashPassword(
                $user,
                $plaintextPassword
            );
            $user->setPassword($hashedPassword);
            $manager->persist($user);
        }
        $manager->flush();
    }
}
