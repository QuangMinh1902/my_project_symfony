<?php

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Articles;
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
    public function new(Request $request, ManagerRegistry $doctrine): Response
    {
        $article = new Articles();
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if (!$article->getId()) {
                $article->setCreateAt(new \DateTimeImmutable());
            }
            $entityManager = $doctrine->getManager();
            $entityManager->persist($article);
            $entityManager->flush();
            return $this->redirectToRoute('app_magasin');
        }
        return $this->render('magasin/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/magasin/article/edit/{id}", name="edit_article")
     */
    public function edit(Articles $article, Request $request)
    {
        $form = $this->createForm(Articles::class, $article);
        $form->handleRequest($request);
        return $this->render('magasin/edit.html.twig', [
            "form"=>$form->createView(),
        ]);
    }
}
