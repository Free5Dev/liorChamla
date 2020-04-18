<?php 
namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class HomeController extends AbstractController {

    /**
     * @Route("/home", name="homepage")
     *
     * @return void
     */
    public function home(){
        return $this->render("home.html.twig");
    }
}