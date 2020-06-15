<?php

/**
 * 
 * cette classe est resté dans ce dossier et avec le nom de subscriber parceque dans un premier temps on a fait la meme chose mais avec un subscriber. 
 * Elle devrait etre dans les listener dans le dossier doctrine
 */


namespace App\EventSubscriber;

use ApiPlatform\Core\EventListener\EventPriorities;
use App\Entity\Customer;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Security\Core\Security;

class CustomerUserSubscriber
{
    protected Security $security;

    public function __construct(Security $secutity)
    {
        $this->security = $secutity;
    }

    public function prePersist(Customer $customer)
    {

        if (!$customer->getUser()) {
            $customer->setUser($this->security->getUser());
        }
    }
}
