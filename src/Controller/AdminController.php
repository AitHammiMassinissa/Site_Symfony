<?php

namespace App\Controller;

use App\Entity\Tableformation;
use App\Form\FormationType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;


class AdminController extends AbstractController
{
    /**
     * @return Response
     * @IsGranted("ROLE_ADMIN", message="Ooops ! il y a une erreur ou cette page n'existe pas")
     * @Route ("/creation",name="app_formations_creation",methods={"GET|POST"})
     */
    public function create_formation(Request $request,EntityManagerInterface  $em):Response{

        $formation= new Tableformation();
        $formulaire= $this->createForm(FormationType::class,$formation);
        $formulaire->handleRequest($request); // elle récupére que les donnée de type Post
        if ($formulaire->isSubmitted() && $formulaire->isValid()){
            $em->persist($formation);
            $em->flush();
            $this->addFlash('success','Une nouvelle formation a été crée avec succès');
            return $this->redirectToRoute('app_formations_home');
        }

        return $this->render("formations/creation_formation.html.twig",[
            'formulaire'=>$formulaire->createView()
        ]);
    }
    /**
     * @return Response
     * @IsGranted("ROLE_ADMIN", message="Ooops ! il y a une erreur ou cette page n'existe pas")
     * @Route ("/modifier/{id<[0-9]+>}",name="app_formations_modifier",methods={"GET","PUT"})
     */
    public function modifier(Tableformation $description,Request $request,EntityManagerInterface  $em):Response{
        $formulaire= $this->createForm(FormationType::class,$description,[
            'method'=>'PUT'
        ]);
        $formulaire->handleRequest($request); // elle récupére que les donnée de type Post
        if ($formulaire->isSubmitted() && $formulaire->isValid()){
            $em->flush();
            $this->addFlash('updated','Cette formation a été modifiée avec succès');
            return $this->redirectToRoute('app_formations_home');
        }
        return $this->render("formations/modifier_detail.html.twig",[
            'description'=>$description,
            'formulaire'=>$formulaire->createView()
        ]);
    }
    /**
     * @return Response
     * @IsGranted("ROLE_ADMIN", message="Ooops ! il y a une erreur ou cette page n'existe pas")
     * @Route ("/supprimer/{id<[0-9]+>}",name="app_formations_supprimer",methods={"DELETE"})
     */
    public function supprimer(Request $request,Tableformation $description,EntityManagerInterface  $em):Response{
        if($this->isCsrfTokenValid('formation_deletion_'. $description->getId(),$request->request->get('csrf_token'))){
            $em->remove($description);
            $em->flush();
            $this->addFlash('suppression','Formation supprimer');
        }

        return $this->redirectToRoute('app_formations_home');
    }
}
