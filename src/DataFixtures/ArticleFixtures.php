<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Articles;
use App\Entity\Categories;
use Doctrine\ORM\Mapping\Id;

class ArticleFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i = 1; $i <= 10; $i++) {
            $article = new Articles();
            if ($i % 2) {
                $article->setNom("Montre électronique n° $i");
                $article->setDescription("Description de la montre n° $i");
                $article->setPrix($i * 10);
                $article->setNombresEnStock($i);
                // $article->setIdCategorie(new Categories());
                $article->setCreateAt(new \DateTimeImmutable());
            }else{
                $article->setNom("Balace électronique n° $i");
                $article->setDescription("Description de la balance n° $i");
                $article->setPrix($i * 11);
                $article->setNombresEnStock($i);
                // $article->setIdCategorie(new Categories());
                $article->setCreateAt(new \DateTimeImmutable());
            }
            $manager->persist($article);
        }

        $manager->flush();
    }
}
