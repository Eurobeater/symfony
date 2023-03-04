<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleType;
use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

/**
 * @Route("/article")
 */
class ArticleController extends AbstractController
{
    private $articleRepository;
    
    public function __construct( ArticleRepository $articleRepository)
    {
        $this->articleRepository = $articleRepository;
    }
    
    /**
     * @Route("/listar", name="article_listar")
     */
    public function listar()
    {
        $articles = $this->articleRepository->findAll();
        return $this->render('article/listar.html.twig', [
            'articles' => $articles
        ]);
    }

    /**
     * @Route("/new", name="article_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $article = new Article();
        $form = $this->createForm(ArticleType::class, $article);
        
        $form->add('Aceptar', SubmitType::class );
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $this->articleRepository->save($article);
            
            return $this->redirectToRoute('article_listar');
        }

        return $this->render('article/new.html.twig', [
            'article' => $article,
            'form' => $form->createView(),
        ]);
    }

   
    /**
     * @Route("/edit/{id}", name="article_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, $id )
    {
        
        $article = $this->articleRepository->find($id);
        $form = $this->createForm(ArticleType::class, $article);
        $form->add('Aceptar', SubmitType::class );
        $form->add('Borrar', SubmitType::class );
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->articleRepository->save($article);

            if( $form->get('Aceptar')->isClicked() ) // seleccion boton 
                return $this->redirectToRoute('article_listar');            
            else
                return $this->redirectToRoute('article_delete', [ 'id' => $id ] );
    
        }

        return $this->render('article/edit.html.twig', [
            'article' => $article,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/delete/{id}", name="article_delete")
     */
    public function delete( $id)
    {
        $article = $this->articleRepository->find($id);
        $this->articleRepository->remove($article);
        return $this->redirectToRoute('article_listar');
    }
}
