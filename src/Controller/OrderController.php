<?php

namespace App\Controller;

use App\Entity\Tableformation;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OrderController extends AbstractController

{
      /**
     * @Route("/formations/{id<[0-9]+>}/date/{Id<[0-9]+>}",name="app_inscription")
     * )
     */
    public function recap($date, Tableformation $description): Response
    {
        if (! $this->getUser()) {
            $this->addFlash('error', 'Vous devez vous connecter pour accéder à cette page');
            return $this->redirectToRoute('app_login');
        }
        if (! $this->getUser()->isVerified()) {
            $this->addFlash('error', "Vous devez confirmer votre émail pour pouvoir accéder aux différentes pages");
            return $this->redirectToRoute('app_formations_home');
        }
        
        return $this->render('inscription/recapitulatif.html.twig',compact('date','description'));
    }
}
