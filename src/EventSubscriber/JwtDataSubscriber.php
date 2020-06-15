<?php

namespace App\EventSubscriber;

use App\Entity\User;
use Lexik\Bundle\JWTAuthenticationBundle\Event\AuthenticationSuccessEvent;
use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTCreatedEvent;
use Lexik\Bundle\JWTAuthenticationBundle\Events;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class JwtDataSubscriber implements EventSubscriberInterface
{

    public static function getSubscribedEvents()
    {
        return [
            Events::JWT_CREATED => 'addFullName'
        ];
    }


    public function addFullName(JWTCreatedEvent $event)
    {
        /** @var User */
        $user = $event->getUser();

        $data = $event->getData();

        $data['fullName'] = $user->getFullName();

        $event->setData($data);
    }
}
