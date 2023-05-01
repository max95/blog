<?php

namespace App\Controller;


use App\Entity\Comment;
use App\Form\CommentType;
use App\Repository\ArticleRepository;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends AbstractController
{
    /**
     * @Route("", name="liste_article", methods={"GET"})
     */
    public function listeArticles(ArticleRepository $articleRepository): Response
    {
        $articles = $articleRepository->findby([
            'state' => 'publie'
        ]);
        
        return $this->render('default/index.html.twig', [
            'articles' => $articles,
            'brouillon' => false
        ]);
    }

    /**
     * @Route("/brouillon", name="liste_article_brouillon", methods={"GET"})
     */
    public function listeArticlesbrouillon(ArticleRepository $articleRepository): Response
    {
        $articles = $articleRepository->findby([
            'state' => 'brouillon'
        ]);
        
        return $this->render('default/index.html.twig', [
            'articles' => $articles,
            'brouillon' => true
        ]);
    }

    /**
     * @Route("/{id}", name="vue_article", methods={"GET","POST"}, requirements={"id" = "\d+"})
     */
    public function vueArticle(ArticleRepository $articleRepository, $id, Request $request, EntityManagerInterface $manager)
    {
        $article = $articleRepository->find($id);

        $comment = new Comment();
        $comment->setArticle($article);
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $manager->persist($comment);
            $manager->flush();

            return $this->redirectToRoute('vue_article', ['id' => $article->getId()]);
        }

        return $this->render('default/vue.html.twig', [
            'article' => $article,
            'form' => $form->createView()
        ]);
    }


}
