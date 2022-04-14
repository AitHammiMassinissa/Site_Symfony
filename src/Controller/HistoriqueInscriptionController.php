<?php

namespace App\Controller;

use App\Entity\Order;
use App\Entity\Tableformation;
use App\Manager\TableFormationManager;
use App\Repository\CommandePayementRepository;
use App\Repository\OrderRepository;
use App\Repository\TableformationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HistoriqueInscriptionController extends AbstractController
{
    /**
     * @Route("/historique/inscription", name="app_historique_inscription")
     */
    public function inscription_orders(TableformationRepository $formationmanager,OrderRepository $ripo,CommandePayementRepository $ripopay): Response
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
        
        return $this->render('inscription/MesInscription.html.twig', [
            'user' => $this->getUser(),
            'orders' => $ripo->findBy(['date_inscription_user_id'=>$user->getId()]),
            'orders2'=>$ripopay->findBy(['UserId'=>$user->getId()])
        ]);
    }
     /**
     * @Route ("/historique/inscription/supprimer/date/{Id<[0-9]+>}",name="app_inscription_supprimer",methods={"DELETE"})
     */
    public function supprimer(Request $request,$date,EntityManagerInterface  $em):Response{
        if($this->isCsrfTokenValid('formation_deletion_'. $date->getId(),$request->request->get('csrf_token'))){
            $em->remove($date);
            $em->flush();
            $this->addFlash('suppression','Inscription supprimer');
        }

        return $this->redirectToRoute('app_historique_inscription');
    }
}
