<?php

namespace App\Controller;

use ApiPlatform\Core\Filter\Validator\Length;
use App\Entity\Order;
use App\Entity\Tableformation;
use App\Entity\User;
use App\Form\DevisType;
use App\Form\FindDateType;
use App\Form\FormationType;
use App\Form\ProposeDateType;
use App\Repository\OrderRepository;
use App\Repository\TableformationRepository;
use Doctrine\Common\EventManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route ;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\Id;
use Exception;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormBuilder;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class FormationsController extends AbstractController
{

    /**
     * @return Response
     * @Route ("/", name="app_formations_home",methods="GET")
     */
    public function index(TableformationRepository $FormaRepo): Response
    {
        $formations = $FormaRepo->findBy([], ['createdAt'=>'DESC']);
        return $this->render("formations/PageAc.html.twig", compact('formations'));
    }
     
    /**
     * @return Response
     * @Route ("/formations/{id<[0-9]+>}",name="app_formations_voirdetail",methods={"GET","POST"})
    */
    public function voir_detail(OrderRepository $ripo, Tableformation $description, Request $request, EntityManagerInterface $em, int $id,\Swift_Mailer $mailer):Response
    {
        if (! $this->getUser()) {
            $this->addFlash('error', 'Vous devez vous connecter pour accéder à cette page');
            return $this->redirectToRoute('app_login');
        }
        if (! $this->getUser()->isVerified()) {
            $this->addFlash('error', "Vous devez confirmer votre émail pour pouvoir accéder aux différentes pages");
            return $this->redirectToRoute('app_formations_home');
        }

        $date=new Order();
        $user=$this->getUser();
        // $user=$this->getUser();
        $formulaire = $this->createForm(FindDateType::class, $date);
        $formulaire2 = $this->createForm(ProposeDateType::class);
        $formulaire->handleRequest($request);
        $formulaire2->handleRequest($request);
       
       
        if ($formulaire->isSubmitted() && $formulaire->isValid()) {
            $existe=$ripo->findAll();
            
            $i=0;
            if (!count($existe)) {
                $date->setDateInscriptionUserId($user);
                $date->setIdFormation($description);
                $em->persist($date);
                $em->flush();
                $this->addFlash('success', "Vous vous etes inscrit a cette formation, vous pouvez procéder au payement");
                return $this->redirectToRoute('app_inscription', [
                    'id'=>$id,
                    'date'=>$date,
                    'Id'=>$date->getId()
                ]);
            } else {
                for ($i=0;$i<count($existe);$i++) {
                    if (($existe[$i]->getDateInscriptionUserId()->getId()==$user->getId()) && ($existe[$i]->getIdFormation()->getId()==$description->getId())) {
                        $date=$ripo->findOneBy(['date_inscription_user_id'=>$user]);
                        
                        $this->addFlash('success', "Vous etes déjà inscrit a cette formation, vous pouvez procéder au payement");
                        return $this->redirectToRoute('app_adresse_facturation', [
                        'id'=>$id,
                        'Id'=>$date->getId()
                    ]);
                    } 
                    }
                    $date->setDateInscriptionUserId($user);
                    $date->setIdFormation($description);
                    $em->persist($date);
                    $em->flush();
                    return $this->redirectToRoute('app_inscription', [
                    'id'=>$id,
                    'Id'=>$date->getId()
                    ]);
                }
            }
        
                if ($formulaire2->isSubmitted() && $formulaire2->isValid()) {
                    $contact=$formulaire2->getData();
                    $message=(new \Swift_Message('Date proposer'))
                    ->setFrom($contact['email'])
                    ->setTo('amine.hbibiy@solway-cs.com')
                    ->setBody(
                        $this->renderView(
                            'EmailProposeDate/proposedate.html.twig',compact('contact')
                        ),
                        'text/html'
                    )
                    ;
                    $mailer->send($message);
                    $this->addFlash('success','message envoyé');
                   return $this->redirectToRoute('app_reponse_a_la_date_proposer');
                }
                return $this->render("formations/voir_detail.html.twig", [
            'description'=>$description,
            'form_date'=>$formulaire->createView(),
            'form_propose'=>$formulaire2->createView()
        ]);
            }
        }
    
