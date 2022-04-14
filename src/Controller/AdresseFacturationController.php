<?php

namespace App\Controller;

use App\Entity\Tableformation;
use App\Form\DevisType;
use App\Form\UserFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdresseFacturationController extends AbstractController
{
    /**
     * @Route("/formations/{id<[0-9]+>}/cordonneesFacturation/date/{Id<[0-9]+>}", name="app_adresse_facturation",methods={"GET","POST"})
     */
    public function cordonneesFacturation($date,Tableformation $formation,Request $request,EntityManagerInterface $em): Response
    {
        $user=$this->getUser();
        $formulaire2 = $this->createForm(UserFormType::class,$user);
        $formulaire2->handleRequest($request);
        if ($formulaire2->isSubmitted() && $formulaire2->isValid()) {
            $this->addFlash('success','Cordonnées modifier avec succés');
            $em->flush();
            return $this->redirectToRoute('app_adresse_facturation_formulaire2', [
                'id'=>$formation->getId(),
                'Id'=>$date->getId()
            ]);
        }
        return $this->render("inscription/payement/cordonnéesUser.html.twig", [
            'formulaireuser'=>$formulaire2->createView(),
        ]);
       
    }
     /**
     *  @Route("/formations/{id<[0-9]+>}/cordonneesFacturation/date/{Id<[0-9]+>}/formulaire2", name="app_adresse_facturation_formulaire2",methods={"GET","POST"})
     */
    public function adresseFacturation2($date,Tableformation $formation,Request $request,EntityManagerInterface $em): Response
    {
        $user=$this->getUser();
        $formulaire = $this->createForm(DevisType::class,$user);
        $formulaire->handleRequest($request);
       
        if ($formulaire->isSubmitted() && $formulaire->isValid()) {
            $this->addFlash('success','Adresse de facturation modifier avec succés');
            $em->flush();
            return $this->redirectToRoute('app_payement', [
                'id'=>$formation->getId(),
                'Id'=>$date->getId(),
                'date'=>$date,
            ]);
        }
        return $this->render("inscription/payement/adressedefacturation.html.twig", [
            'formulaireuseradresse'=>$formulaire->createView()
        ]);
       
    }
}
