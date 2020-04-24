<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\AccountType;
use App\Entity\PasswordUpdate;
use App\Form\RegistrationType;
use App\Form\PasswordUpdateType;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AccountController extends AbstractController
{
    /**
     * Permet de se connecter et d'afficher le formulaire de connection
     * 
     * @Route("/login", name="account_login")
     * @return Response
     */
    public function login(AuthenticationUtils $utils)
    {
        $error = $utils->getLastAuthenticationError();
        //dump($error);
        $username = $utils->getLastUsername();

        return $this->render('account/login.html.twig',[
            'hasError' => $error !== null,
            'username' =>$username
        ]);
    }
    /**
     * Permet de decoonnecter un utilisateur
     *@Route("/logout", name="account_logout")
     * @return void
     */
    public function logout(){

    }
    /**
     * Permet d'afficher le formulaire d'inscription
     *@Route("/register", name="account_register")
     * @return Response
     */
    public function register(Request $request, UserPasswordEncoderInterface $encode){
        $user = new User();
        $form =$this->createForm(RegistrationType::class, $user);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $hash = $encode->encodePassword($user, $user->getHash());
            $user->setHash($hash);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
        }
        return $this->render("account/registrer.html.twig",[
            'form' =>$form->createView()
        ]);
    }
    /**
     * Permet d'editer un profile utilisateur
     *@Route("/account/profile", name="account_profile")
     *@IsGranted("ROLE_USER")
     * @return Response
     */
    public function profile(Request $request){
        $user = $this->getUser();
        $form = $this->createForm(AccountType::class, $user);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
            $this->addFlash(
                'success',
                "Les données ont été enresistrés avec succès."
            );
        }
        return $this->render("account/profile.html.twig",[
            'form' => $form->createView()
        ]);
    }
    /**
     * Permet de modifier le mots de passe
     * @Route("/account/password-update", name="account_update")
     *@IsGranted("ROLE_USER")
     * @return Response
     */
    public function updatePassword(Request $request, UserPasswordEncoderInterface $encoder){
        $user = $this->getUser();
        $passwordUpdate = new PasswordUpdate();
        $form = $this->createForm(PasswordUpdateType::class, $passwordUpdate);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            //1- verification si l'ancien mots de passe correspond bien à celui de la bdd
            if(!password_verify($passwordUpdate->getOldPassword(), $user->getHash())){
                //message d'erreur en cas de mots de passe incorrecte
                $form->get('oldPassword')->addError(new FormError("Le mots de passe que vous avez tapé n'est pas votre mots de passe actuel !"));
            }else{
                $newPassword = $passwordUpdate->getNewPassword();
                $hash =$encoder->encodePassword($user, $newPassword);
                $user->setHash($hash);
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($user);
                $entityManager->flush();
                $this->addFlash(
                    'success',
                    "Le mots de passe à été bien modifier"
                );
                return $this->redirectToRoute("homepage");
            }
        }
        return $this->render("account/password.html.twig",[
            'form' => $form->createView()
        ]);
    }
    /**
     * Permet d'afficher le profil utilisateur
     * @Route("/account", name="account_index")
     *@IsGranted("ROLE_USER")
     * @return Response
     */
    public function myAccount(){
        return $this->render('user/index.html.twig',[
            'user' =>$this->getUser()
        ]);
    }
}
