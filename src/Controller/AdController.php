<?php

namespace App\Controller;

use App\Entity\Ad;
use App\Entity\Image;
use App\Form\AnnonceType;
use App\Repository\AdRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdController extends AbstractController
{
    /**
     * @Route("/ads", name="ads_index")
     */
    public function index(AdRepository $repo,SessionInterface $session)
    {
        dump($session);
        // $repo = $this->getDoctrine()->getRepository(Ad::class);
        $ads = $repo->findAll();
        return $this->render('ad/index.html.twig', [
            'controller_name' => 'AdController',
            'ads' => $ads
        ]);
    }
     /**
     * Permet de creer une nouvelle annonce
     * @Route("/ads/new", name="ads_create")
     *
     * @return Response
     */
    public function create(Request $request){
        $ad = new Ad();

       
        $form =$this->createForm(AnnonceType::class, $ad);
        $form->handleRequest($request);
       // dump($ad);
           
       if($form->isSubmitted() && $form->isValid()){
            $entityManager = $this->getDoctrine()->getManager();

           foreach($ad->getImages() as $image){
               $image->setAd($ad);
               $entityManager->persist($image);
           }
           $entityManager->persist($ad);
           $entityManager->flush();
           //Les messages flash
            $this->addFlash(
                'success',
                "L'annonce <strong>{$ad->getTitle()}</strong> à bien été enresistrée !"
            ); 
           return $this->redirectToRoute('ads_show', [
               'slug' =>$ad->getSlug()
           ]);
       }
        return $this->render("ad/new.html.twig",[
            'form' => $form->createView()
        ]);
    }
    /**
     * Permet d'editer une annonce
     *@Route("/ads/{slug}/edit", name="ads_edit")
     * @return Response
     */
    public function edit(Ad $ad, Request $request){

        $form =$this->createForm(AnnonceType::class, $ad);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $entityManager = $this->getDoctrine()->getManager();

           foreach($ad->getImages() as $image){
               $image->setAd($ad);
               $entityManager->persist($image);
           }
           $entityManager->persist($ad);
           $entityManager->flush();
           //Les messages flash
            $this->addFlash(
                'success',
                "Les modifications de l'annonce <strong>{$ad->getTitle()}</strong> ont bien été enresistrée !"
            ); 
           return $this->redirectToRoute('ads_show', [
               'slug' =>$ad->getSlug()
           ]);
        }
        return $this->render("ad/edit.html.twig",[
            'form' => $form->createView(),
            'ad' => $ad
        ]);
    }
    /**
     * Permet d'affiche un show de l'annonce qui correspond
     *@Route("/ads/{slug}", name="ads_show")
     * @return void
     */
    public function show(Ad $ad){
        //public function show($slug, AdRepository $repo){}
        //$ad = $repo->findOneBySlug($slug);
        return $this->render("ad/show.html.twig",[
            'ad' => $ad
        ]);
    }
   
}
