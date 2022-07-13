<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Articles;

class MagasinController extends AbstractController
{
    /**
     * @Route("/magasin", name="app_magasin")
     */
    public function showArticles(ManagerRegistry $doctrine): Response
    {
        $repository = $doctrine->getRepository(Articles::class);
        $articles = $repository->findAll();;
        // var_dump($articles);
        
        return $this->render('magasin/show.html.twig', [
            'articles' => $articles,
        ]);
    }
}
