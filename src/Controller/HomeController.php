<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Category;
use App\Repository\ArticleRepository;
use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    private $repArticle;
    private $repCategory;

    public function __construct(ArticleRepository $repArticle, CategoryRepository $repCategory)
    {
        $this->repArticle = $repArticle;
        $this->repCategory = $repCategory;
    }

    /**
     * @Route("/", name="home")
     */
    public function home(): Response
    {
        //$repository = $this->getDoctrine()->getRepository(Article::class);
        //$articles = $repository->findAll();
        $articles = $this->repArticle->findAll();
        $categories = $this->repCategory->findAll();

        return $this->render("home/index.html.twig",['articles' => $articles, 'categories'=>$categories]);
    }

    /**
     * @Route("/show/{id}", name="show")
     * @param Article $article
     * @return Response
     */
    public function showArticle(Article $article): Response
    {
        //$showArticle = $this->repoArticle->find($id);

        if(!$article){
            return $this->redirectToRoute('home');
        }
        return $this->render('show/index.html.twig', ['article' => $article]);
    }

    /**
     * @Route("/per-category/{id}", name="per_category")
     */
    public function index(?Category $category): Response
    {
        if ($category){
            $articles = $category->getArticles()->getValues();
            $categories = $this->repCategory->findAll();
        }else{
            $articles = null;
            return $this->redirectToRoute('home');
        }

        return $this->render('per_category/index.html.twig', [
            'articles' => $articles, 'categories'=>$categories
        ]);
    }


}
