<?php

namespace App\Controller;

use App\Form\ChangePasswordFormType;
use App\Form\UserFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class CompteController extends AbstractController
{
    /**
     * @Route("/compte",name="app_compte",methods="GET")
     */
    public function voir_compte(): Response
    {
        if(! $this->getUser()){
            $this->addFlash('error','Vous devez vous connecter pour accéder à cette page');
            return $this->redirectToRoute('app_login');
        }
        if(! $this->getUser()->isVerified()){
            $this->addFlash('error',"Vous devez confirmer votre émail pour pouvoir accéder aux différentes pages");
            return $this->redirectToRoute('app_formations_home');
        }
        return $this->render('compte/voir_compte.html.twig', [
            'controller_name' => 'CompteController',
        ]);
    }
    /**
     * @Route("/compte/modifier",name="app_compte_modifier")
     */
    public function modifier_info(Request $request,EntityManagerInterface $em):Response
    {
        if(! $this->getUser()){
            $this->addFlash('error','Vous devez vous connecter pour accéder à cette page');
            return $this->redirectToRoute('app_login');
        }
        if(! $this->getUser()->isVerified()){
            $this->addFlash('error',"Vous devez confirmer votre émail pour pouvoir accéder aux différentes pages");
            return $this->redirectToRoute('app_formations_home');
        }
        $user=$this->getUser();
        $formulaire = $this->createForm(UserFormType::class,$user);
        $formulaire->handleRequest($request);
        if($formulaire->isSubmitted() && $formulaire->isValid()){
            $em->flush();
            $this->addFlash('success','Compte modifier avec succès');
            return $this->redirectToRoute('app_compte');
        }
        return $this->render('compte/modifier_compte.html.twig', [
            'controller_name' => 'CompteController',
            'form'=>$formulaire->createView()
        ]);
    }
    /**
     * @Route("/compte/modifier/mot_de_passe",name="app_compte_modifier_mot_de_passe",methods={"GET","POST"})
     */
    public function modifier_mot_de_passe(Request $request,EntityManagerInterface $em,UserPasswordEncoderInterface $encoder):Response
    {
        if(! $this->getUser()){
            $this->addFlash('error','Vous devez vous connecter pour accéder à cette page');
            return $this->redirectToRoute('app_login');
        }
        if(! $this->getUser()->isVerified()){
            $this->addFlash('error',"Vous devez confirmer votre émail pour pouvoir accéder aux différentes pages");
            return $this->redirectToRoute('app_formations_home');
        }
        $user=$this->getUser();
        $formulaire = $this->createForm(ChangePasswordFormType::class,null,[
            'current_password_is_required'=>true
        ]);
        $formulaire->handleRequest($request);
        if($formulaire->isSubmitted() && $formulaire->isValid()){
           $user->setPassword(
            $encoder->encodePassword($user,$formulaire['plainPassword']->getData())
        );
            $em->flush();
            $this->addFlash('success','Mot de passe  modifier avec succès');
           return $this->redirectToRoute('app_compte');
    }
        return $this->render('compte/modifier_mot_de_passe.html.twig', [
            'controller_name' => 'CompteController',
            'form'=>$formulaire->createView()
        ]);
    }

}
