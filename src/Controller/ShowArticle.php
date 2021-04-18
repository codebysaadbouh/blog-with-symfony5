<?php

namespace App\Controller;

use App\Entity\Article;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ShowArticle extends AbstractController
{
    /**
     * @Route("/show/{id}", name="show")
     * @param $id
     * @return Response
     */
    public function show($id): Response
    {
        $repository = $this->getDoctrine()->getRepository(Article::class);
        $showArticle = $repository->find($id);

        if(!$showArticle){
            return $this->redirectToRoute('home');
        }
        return $this->render('show/index.html.twig', ['article' => $showArticle]);
    }
}
