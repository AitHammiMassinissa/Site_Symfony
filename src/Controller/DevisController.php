<?php

namespace App\Controller;

use App\Entity\Tableformation;
use App\Entity\User;
use App\Form\DevisType;
use Doctrine\ORM\EntityManagerInterface;
use Dompdf\Dompdf;
use Dompdf\Options;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DevisController extends AbstractController
{
    /**
     * @Route("formation/devis/{id<[0-9]+>}", name="formation_devis")
     */
    public function devis(Tableformation $description, Request $request,EntityManagerInterface $em ,int $id): Response
    {       
        $user=$this->getUser();
         
        if(! $this->getUser()){
            $this->addFlash('error','Vous devez vous connecter pour accéder à cette page');
            return $this->redirectToRoute('app_login');
        }
        if(! $this->getUser()->isVerified()){
            $this->addFlash('error',"Vous devez confirmer votre émail pour pouvoir accéder aux différentes pages");
            return $this->redirectToRoute('app_formations_home');
        }

        $formulaire = $this->createForm(DevisType::class,$user);
        $formulaire->handleRequest($request);
       
        if($formulaire->isSubmitted() && $formulaire->isValid()) {
                $user->setPays($formulaire['pays']->getData());
                $em->flush();
                $this->addFlash('success', "Vous pouvez télécharger votre devis dans cette page ");
                return $this->redirectToRoute('formation_devis_telechargement', [
                    'id'=>$id
                ]);
            }



        return $this->render('devis/devis_form.html.twig', [
            'form_devis'=>$formulaire->createView(),
            'description'=>$description
        ]);
    }
   
/**
     * @Route("formation/devis/telechargement/{id<[0-9]+>}", name="formation_devis_telechargement",methods={"GET","POST"})
     */
    public function devis_telechargement(Tableformation $description,$id): Response
    {       
        $tva=($description->getPrix()*5)/100;
        $totalettc=$description->getPrix()+$tva;
         
        if(! $this->getUser()){
            $this->addFlash('error','Vous devez vous connecter pour accéder à cette page');
            return $this->redirectToRoute('app_login');
        }
        if(! $this->getUser()->isVerified()){
            $this->addFlash('error',"Vous devez confirmer votre émail pour pouvoir accéder aux différentes pages");
            return $this->redirectToRoute('app_formations_home');
        }
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');
        $pdfOptions->setIsPhpEnabled(true);
        $pdfOptions->setIsRemoteEnabled(true);
        
        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);
        
        // Retrieve the HTML generated in our twig file
        $html = $this->renderView('devis/devis_form_telechargement.html.twig', [
            'controller_name' => 'DevisController',
            'description'=>$description,
            'tva'=>$tva,
            'totalettc'=>$totalettc,
        ]);
        
        // Load HTML to Dompdf
        $dompdf->loadHtml($html);
        
        // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
        $dompdf->setPaper('A4', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser (force download)
        $dompdf->stream("devis_solway.pdf", [
            "Attachment" => false
        ]);
    }
}
