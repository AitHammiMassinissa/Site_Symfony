<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ReponseALaDateProposerController extends AbstractController
{
    /**
     * @Route("/reponse/a/la/date/proposer", name="app_reponse_a_la_date_proposer")
     */
    public function index(): Response
    {
        return $this->render('EmailProposeDate/reponseDeSolway.html.twig', [
            'controller_name' => 'ReponseALaDateProposerController',
        ]);
    }
}
