<?php

namespace App\EventSubscriber;


use App\Entity\Order;
use App\Repository\OrderRepository;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ControllerEvent;

class ParamConverterSubscriber implements EventSubscriberInterface
{
    private $dateripo;
   public function __construct(OrderRepository $dateripo)
    {
        $this->dateripo=$dateripo;
    }
    
    public function onKernelController(ControllerEvent $event)
    {
     
       $request=$event->getRequest();
      
       $id=$request->attributes->get('Id');
       $date=$this->dateripo->findOneBy([
           'id'=>$id
       ]);
       $request->attributes->set('date',$date);
    
    }

    public static function getSubscribedEvents()
    {
        return [
            'kernel.controller' => 'onKernelController',
        ];
        
    }
    
}