<?php

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Articles;
use App\Entity\Categories;
use App\Entity\Users;
use Symfony\Component\HttpFoundation\Request;
use App\Form\ArticleType;

class MagasinController extends AbstractController
{
    /**
     * @Route("/magasin", name="app_magasin")
     */
    public function showArticles(ManagerRegistry $doctrine)
    {
        $repository = $doctrine->getRepository(Articles::class);
        $articles = $repository->findAll();

        return $this->render('magasin/show.html.twig', [
            'articles' => $articles,
        ]);
    }

    /**
     * @Route("/magasin/new", name="create_article")
     */
    public function new(Request $request): Response
    {
        $article = new Articles();
        $form = $this->createForm(ArticleType::class);
        return $this->render('magasin/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
