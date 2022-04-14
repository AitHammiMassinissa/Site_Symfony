<?php

namespace App\Manager;

use App\Entity\CommandePayement;
use App\Entity\Tableformation;
use App\Entity\User;
use App\Services\StripeService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class TableFormationManager
{
    /**
     * @var EntityManagerInterface
     */
    protected $em;

    /**
     * @var StripeService
     */
    protected $stripeService;

    /**
     * @param EntityManagerInterface $entityManager
     * @param StripeService $stripeService
     */
    public function __construct(
        EntityManagerInterface $entityManager,
        StripeService $stripeService
    ) {
        $this->em = $entityManager;
        $this->stripeService = $stripeService;
    }

    public function getTableFormation()
    {
        return $this->em->getRepository(Tableformation::class)
            ->findAll();
    }

   

   

    public function intentSecret(Tableformation $formation)
    {
        $intent = $this->stripeService->paymentIntent($formation);

        return $intent['client_secret'] ?? null;
    }

    
    public function stripe(array $stripeParameter, Tableformation $formation)
    {
        $resource = null;
        $data = $this->stripeService->stripe($stripeParameter, $formation);

        if($data) {
            $resource = [
                'stripeBrand' => $data['charges']['data'][0]['payment_method_details']['card']['brand'],
                'stripeLast4' => $data['charges']['data'][0]['payment_method_details']['card']['last4'],
                'stripeId' => $data['charges']['data'][0]['id'],
                'stripeStatus' => $data['charges']['data'][0]['status'],
                'stripeToken' => $data['client_secret']
            ];
        }

        return $resource;
    }

  
    public function create_subscription(array $resource, Tableformation $formation, User $user)
    {
        $order = new CommandePayement();
        $order->setUserId($user);
        $order->setFormationId($formation);
        $order->setPrix($formation->getPrix());
        $order->setReference(uniqid('', false));
        $order->setBrandStripe($resource['stripeBrand']);
        $order->setLast4Stripe($resource['stripeLast4']);
        $order->setIdChargeStripe($resource['stripeId']);
        $order->setStripeToken($resource['stripeToken']);
        $order->setStatusStripe($resource['stripeStatus']);
        $order->setUpdatedAt(new \Datetime());
        $order->setCreatedAt(new \Datetime());
        $this->em->persist($order);
        $this->em->flush();
    }
}