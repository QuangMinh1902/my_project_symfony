<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Articles;
use App\Entity\Categories;
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
        $repository = $doctrine->getRepository(Categories::class);
        $categories = $repository->findAll();
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if (!$article->getId()) {
                $article->setCreateAt(new \DateTimeImmutable());
            }
            $str_id =  $request->request->get('categorie');
            $id_category = intval($str_id);
            $categorie = $repository->find($id_category);
            $categorie->addArticle($article);
            $entityManager = $doctrine->getManager();
            $entityManager->persist($article);
            $entityManager->flush();
            return $this->redirectToRoute('app_magasin');
        }
        return $this->render('magasin/create.html.twig', [
            'form' => $form->createView(),
            'categories' => $categories
        ]);
    }

    /**
     * @Route("/magasin/article/edit/{id}", name="edit_article")
     */
    public function edit(Articles $article, Request $request, ManagerRegistry $doctrine)
    {
        $repository = $doctrine->getRepository(Categories::class);
        $categories = $repository->findAll();
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $str_id =  $request->request->get('categorie');
            $id_category = intval($str_id);
            $categorie = $repository->find($id_category);
            $categorie->addArticle($article);
            $entityManager = $doctrine->getManager();
            $entityManager->persist($article);
            $entityManager->flush();
            return $this->redirectToRoute('app_magasin');
        }
        return $this->render('magasin/edit.html.twig', [
            "form" => $form->createView(),
            'categories' => $categories
        ]);
    }

    /**
     * @Route("magasin/article/delete/{id}", name="delete_article")
     */
    public function delete(Articles $article, ManagerRegistry $doctrine)
    {
        $entityManager = $doctrine->getManager();
        $entityManager->remove($article);
        $entityManager->flush();
        return $this->redirectToRoute("app_magasin");
    }
}
