<?php

namespace App\Controller;

use App\Entity\Tableformation;
use App\Form\DevisType;
use App\Form\UserFormType;
use App\Manager\TableFormationManager;
use App\Repository\CommandePayementRepository;
use App\Repository\OrderRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PayementController extends AbstractController
{
     /**
     * @Route("/formations/{id<[0-9]+>}/payement/date/{Id<[0-9]+>}",name="app_payement",methods={"GET","POST"})
     */
     public function payement($date,Tableformation $formation,TableFormationManager $formationmanager): Response
    
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
       
       
        return $this->render('inscription/payement/payement.html.twig', [
            'user' => $this->getUser(),
            'intentSecret' => $formationmanager->intentSecret($formation),
            'formation' => $formation,
            'date'=>$date,
        ]);
    }

    /**
     * @Route("/formations/{id<[0-9]+>}/payement/date/{Id<[0-9]+>}/load", name="subscription_paiement", methods={"GET", "POST"})
     */
    public function subscription(
        Tableformation $formation,
        
        Request $request,
        
        $date,
        TableFormationManager $formationmanager
    ){
        if(! $this->getUser()){
            $this->addFlash('error','Vous devez vous connecter pour accéder à cette page');
            return $this->redirectToRoute('app_login');
        }
        if(! $this->getUser()->isVerified()){
            $this->addFlash('error',"Vous devez confirmer votre émail pour pouvoir accéder aux différentes pages");
            return $this->redirectToRoute('app_formations_home');
        }

        $user = $this->getUser();

        if($request->getMethod() === "POST") {
            $resource = $formationmanager->stripe($_POST, $formation);

            if(null !== $resource) {
                $formationmanager->create_subscription($resource, $formation, $user);
                return $this->render('inscription/payement/reponse.html.twig', [
                    'formation' => $formation
                ]);
            }
        }
        
        return $this->redirectToRoute('app_payement', ['id' => $formation->getId(),'Id'=>$date->getId()]);
    }
    /**
     * @Route("/user/payment/orders", name="payment_orders", methods={"GET"})
     * @param ProductManager $productManager
     * @return Response
     */
    public function payment_orders(TableFormationManager $formationmanager,CommandePayementRepository $ripo): Response
    {
        $user=$this->getUser();
        if(!$this->getUser() ){
            $this->addFlash('error','Vous devez vous connecter pour accéder à cette page');
            return $this->redirectToRoute('app_login');
        }
        if(! $this->getUser()->isVerified()){
            $this->addFlash('error',"Vous devez confirmer votre émail pour pouvoir accéder aux différentes pages");
            return $this->redirectToRoute('app_formations_home');
        }
        return $this->render('inscription/payement/payment_story.html.twig', [
            'user' => $this->getUser(),
            'orders' => $ripo->findBy(['UserId'=>$user->getId()]),
          'sumOrder' => $ripo->countSoldeOrder($this->getUser()),
        ]);
    }
    
}
