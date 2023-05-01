<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Category;
use App\Form\ArticleType;
use App\Form\CategoryType;

use App\Repository\CategoryRepository;

use Doctrine\ORM\EntityManagerInterface;

use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin")
 */

class AdminController extends AbstractController
{
    #[Route('/admin', name: 'app_admin')]
    public function index(): Response
    {
        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }

    /**
     * @Route("/article/ajouter", name="ajout_article")
     * @Route("/article/{id}/edition", name="edition_article", methods={"GET","POST"}, requirements={"id" = "\d+"})
     */
    public function ajouter(Article $article=null, Request $request, CategoryRepository $categoryRepository, EntityManagerInterface $manager){
        if($article === null){
            $article = new Article();
        }

        $form = $this->createForm(ArticleType::class, $article);
        
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            if($form->get('brouillon')->isClicked()){
                $article->setState('brouillon');
            }
            else{
                $article->setState('publie');
            }

            if($article->getId() === null){
                $manager->persist($article);
            }
            
            $manager->flush();

            return $this->redirectToRoute('liste_article');
        }

        return $this->render('default/ajout.html.twig',[
            'form' => $form->createView()
        ]);
    }

    /**
    * @Route("/category",name="liste_category")
    */
    public function listeCategory(CategoryRepository $CategoryRepository, Request $request, EntityManagerInterface $manager){
        $category = new Category();
        $category = $CategoryRepository->findall();

        $new_category = new Category();

        $form = $this->createForm(CategoryType::class, $new_category);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $manager->persist($new_category);
            $manager->flush();dump($form);

            return $this->redirectToRoute('liste_category');
        }

        return $this->render('default/category.html.twig',[
            'category' => $category
            ,'form' => $form->createView()
        ]);
    }

    /**
    * @Route("/remove_category/{id}",name="supprimer_category", methods={"GET"}, requirements={"id" = "\d+"})
    */
    public function del_category(CategoryRepository $CategoryRepository,$id, Request $request, EntityManagerInterface $manager){
        $category = $CategoryRepository->find($id);

        $manager->remove($category);
        $manager->flush();

        return $this->redirectToRoute('liste_category');
    }
}
