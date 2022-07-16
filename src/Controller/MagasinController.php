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
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class MagasinController extends AbstractController
{
    /**
     * @Route("/magasin", name="app_magasin")
     * @IsGranted("ROLE_ADMIN")
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
     * @IsGranted("ROLE_ADMIN")
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
     * @IsGranted("ROLE_ADMIN")
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
     * @IsGranted("ROLE_ADMIN")
     */
    public function delete(Articles $article, ManagerRegistry $doctrine)
    {
        $entityManager = $doctrine->getManager();
        $entityManager->remove($article);
        $entityManager->flush();
        return $this->redirectToRoute("app_magasin");
    }

    /**
     * @Route("magasin/categorie/stocks",name="show_stocks")
     * @IsGranted("ROLE_ADMIN")
     */
    public function show_stock(ManagerRegistry $doctrine, Request $request, Articles $articles = null)
    {
        $repository = $doctrine->getRepository(Categories::class);
        $categories = $repository->findAll();
        if ($request->request->get('categorie')) {
            $id_category = intval($request->request->get('categorie'));
            $categorie = $repository->find($id_category);
            $articles = $categorie->getArticles();
        }
        return $this->render('magasin/show_stock.html.twig', [
            'categories' => $categories,
            'articles' => $articles
        ]);
    }
}
