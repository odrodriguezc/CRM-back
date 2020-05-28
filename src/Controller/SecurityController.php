<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class SecurityController extends AbstractController
{
    /**
     * @Route("/api/login_classic", name="security_login_classic", methods={"POST"})
     */
    public function login_classic()
    {
        $user = $this->getUser();


        return $this->json([
            'user' => $user->getUsername(),
            'roles' => $user->getRoles(),
            'message' => 'authentication successfull'
        ]);
    }
}
