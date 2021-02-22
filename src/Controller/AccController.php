<?php

namespace App\Controller;

use App\Entity\PassUpdate;
use App\Entity\User;
use App\Form\AccType;
use App\Form\PassUpdateType;
use App\Form\RegistrationType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Form\FormError;

class AccController extends AbstractController
{
    /**
     * Se connecter
     * 
     * @Route("/login", name="account_login", methods={"GET", "POST"})
     */
    public function login(AuthenticationUtils $authenticationUtils): Response{

        $user = $authenticationUtils->getLastUsername();
        $error = $authenticationUtils->getLastAuthenticationError();

        //dump($error);

        return $this->render('account/login.html.twig', [
            'hasError' => $error !== null,
            'user' => $user
        ]);
    }

    /**
     * Se déconnecter
     *
     * @Route("/logout", name="account_logout")
     * 
     * @return void
     */
    public function logout(){

    }

    /**
     * S'enregistrer
     * 
     * @Route("/register", name="account_register")
     *
     * @return Response
     */
    public function register(EntityManagerInterface $manager, Request $request, UserPasswordEncoderInterface $encoder){
        $user = new User();
        $form = $this->createForm(RegistrationType::class, $user);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $hash = $encoder->encodePassword($user, $user->getHash());
            $user->setHash($hash);
            $manager->persist($user);
            $manager->flush();
            $this->addFlash('success', 'Votre compte a bien été créé !');
            return $this->redirectToRoute('account_login');
        }
        return $this->render('account/registr.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * Modification du profil d'utilisateur
     * 
     * @Route("/account/profile", name="account_profile")
     *
     * @return Response
     */
    public function account(Request $request, EntityManagerInterface $manager){
        $user = $this->getUser();
        $form = $this->createForm(AccType::class, $user);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $manager->persist($user);
            $manager->flush();
            $this->addFlash('success', 'Votre profile a bien été modifié !');
        }
        return $this->render('account/profile.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * Modifier le mot de passe
     * 
     * @Route("account/password-update", name="account_pass_update")
     *
     * @return Response
     */
    public function passwordUpdate(Request $request, UserPasswordEncoderInterface $encoder, EntityManagerInterface $manager){
        $passUpdate = new PassUpdate();
        $user = $this->getUser();
        $form = $this->createForm(PassUpdateType::class, $passUpdate);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            if(!password_verify($passUpdate->getOldPass(), $user->getHash())){
                $form->get('oldPass')->addError(new FormError("Tapez votre mot de passe actuel !"));
            }else{
            $newPass = $passUpdate->getNewPass();
            $hash = $encoder->encodePassword($user, $newPass);
            $user->setHash($hash);
            $manager->persist($user);
            $manager->flush();
            $this->addFlash('success', "Votre mot de passe a été modifié !");
            return $this->redirectToRoute('homepage');
            }
        }

        return $this->render('account/pass.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
