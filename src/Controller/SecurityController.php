<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegisterType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class SecurityController extends AbstractController
{
    private $passwordEncoder;
    public function __construct(UserPasswordEncoderInterface $passwordEncoder){
        $this->passwordEncoder = $passwordEncoder;
    }

    /**
     * @Route("/register", name="security_register")
     */
    public function register(Request $request)
    {
        $user = new User();
        $form = $this->createForm(RegisterType::class, $user);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $user->setPassword($this->passwordEncoder->encodePassword($user, $user->getPassword()));
            $user = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
            return $this->redirectToRoute("security_login");
        }
        return $this->render('security/register.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    /**
     * Permet d'afficher la page d'identification
     *@Route("/login", name="security_login")
     * @return Response
     */
    public function login(AuthenticationUtils $authenticationUtils){
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();
        return $this->render("security/login.html.twig",[
            'last_username' => $lastUsername,
            'error'         => $error,
        ]);
    }
    /**
     * Permet de deconner l'utilisateur
     *@Route("/logout", name="security_logout")
     * @return Response
     */
    public function logout(){

    }
}
