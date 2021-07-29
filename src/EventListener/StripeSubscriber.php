<?php

namespace App\EventListener;

use Miracode\StripeBundle\Event\StripeEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class StripeSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return [
            'stripe.charge.succeeded' => 'onChargeSucceededEvent',
        ];
    }

    //[...]
    
    public function onChargeSucceededEvent(StripeEvent $event)
    {
        $stripeEvent = $event->getEvent(); //Stripe event object (instanceof \Stripe\Event)
        $charge = $event->getObjectData(); //Stripe charge object (instanceof \Stripe\Charge)
    }
}