<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Categories;

class CategorieFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $first_categorie = new Categories();
        $first_categorie->setNom("Bijoux");
        $first_categorie->setNombreProduits(250);
        $manager->persist($first_categorie);

        $second_categorie = new Categories();
        $second_categorie->setNom("Electroménager");
        $second_categorie->setNombreProduits(330);
        $manager->persist($second_categorie);
        $manager->flush();
    }   
}
