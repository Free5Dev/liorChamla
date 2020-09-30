<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Comment;
use App\Entity\Category;
use App\Form\ArticleType;
use App\Form\CommentType;
use App\Repository\ArticleRepository;
use App\Repository\CommentRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BlogController extends AbstractController
{
    /**
     * @Route("/blog", name="blog")
     */
    public function index(ArticleRepository $repo)
    {
        // $repo = $this->getDoctrine()->getRepository(Article::class);
        $articles = $repo->findAll();
        return $this->render('blog/index.html.twig', [
            'articles' => $articles,
        ]);
    }
    /**
     * Permet d'afficher la page d'acceuil
     *@Route("/", name="homepage")
     * @return Response
     */
    public function home(){
        return $this->render("blog/home.html.twig");
    }
     /**
     * Permet d'afficher la creation d'un article et aussi la modification d'un article
     *@Route("/blog/new", name="blog_form")
     *@Route("/blog/{id}/edit", name="blog_edit")
     * @return Response
     */
    public function form(Article $article=null,Request $request){
        if(!$article){
            $article = new Article();
        }
        // $form = $this->createFormBuilder($article)
        //             ->add('title')
        //             ->add('content')
        //             ->add('image')
        //             ->add('category', EntityType::class, [
        //                 'class' =>Category::class,
        //                 'choice_label' => 'title'
        //             ])
        //             ->add('createdAt')
        //             ->getForm();
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            if(!$article->getId()){
                $article->setCreatedAt(new \DateTime());
            }
            $article = $form->getData();

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($article);
            $entityManager->flush();

            return $this->redirectToRoute("blog_show", ['id'=>$article->getId()]);
        }
        return $this->render("blog/form.html.twig",[
            'form' => $form->createView(),
            'edit_mod' => $article->getId() !== null
        ]);
    }
    /**
     * Permet d'afficher la description d'un article
     *@Route("/blog/{id}", name="blog_show")
     * @return Response
     */
    // public function show($id){
    public function show(Article $article, Request $request){
        // $repo = $this->getDoctrine()->getRepository(Article::class);
        // $article = $repo->find($id);
        $comment = new Comment();
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $comment->setArticle($article)
                    ->setCreatedAt(new \DateTime());
            
            $comment = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($comment);
            $entityManager->flush();

            return $this->redirectToRoute("blog_show", ['id'=>$article->getId()]);
        }
        return $this->render("blog/show.html.twig",[
            'article' => $article,
            'form' => $form->createView()
        ]);
    }
   
}

