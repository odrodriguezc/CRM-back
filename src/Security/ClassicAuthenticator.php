<?php

namespace App\Security;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Guard\AbstractGuardAuthenticator;

class ClassicAuthenticator extends AbstractGuardAuthenticator
{

    protected UserPasswordEncoderInterface $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function supports(Request $request)
    {
        return $request->getMethod() === "POST" && $request->attributes->get('_route') === "security_login_classic";
    }

    public function getCredentials(Request $request)
    {
        $credentials = json_decode($request->getContent(), true);

        if (!$credentials) {
            throw new AuthenticationException("The JSON wans not well formatted ");
        }

        return $credentials;
    }

    public function getUser($credentials, UserProviderInterface $userProvider)
    {
        if (empty($credentials['username']) || empty($credentials['password'])) {
            throw new AuthenticationException("Password or Username not found");
        }
        $user = $userProvider->loadUserByUsername($credentials['username']);
        return $user;
    }

    public function checkCredentials($credentials, UserInterface $user)
    {
        return $this->encoder->isPasswordValid($user, $credentials['password']);
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
    {
        return new JsonResponse([
            'message' => $exception->getMessage()

        ], 400);
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey)
    {
    }

    public function start(Request $request, AuthenticationException $authException = null)
    {
        return new JsonResponse([
            'message' => "Vous devez être connecté pour acceder à cette route "
        ], 403);
    }

    public function supportsRememberMe()
    {
        // todo
    }
}
