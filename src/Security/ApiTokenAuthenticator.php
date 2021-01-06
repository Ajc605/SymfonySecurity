<?php

namespace App\Security;

use App\Repository\ApiToeknRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Guard\AbstractGuardAuthenticator;

class ApiTokenAuthenticator extends AbstractGuardAuthenticator
{
    /**
     * @var ApiToeknRepository
     */
    private $toeknRepository;

    public function __construct(ApiToeknRepository $toeknRepository)
    {
        $this->toeknRepository = $toeknRepository;
    }


    public function supports(Request $request)
    {
        // Checks that Authorization is in the header and it is the first in the header and it contains Bearer
        return $request->headers->has('Authorization')
            && 0 === strpos($request->headers->get('Authorization'), 'Bearer');
    }

    public function getCredentials(Request $request)
    {
        $authHeader = $request->headers->get('Authorization');

        // return without the Bearer
        return substr($authHeader, 7);
    }

    public function getUser($credentials, UserProviderInterface $userProvider)
    {
        $token = $this->toeknRepository->findOneBy([
            'token' => $credentials
        ]);

        if(!$token) {
            return;
        }

        return $token->getUser();
    }

    public function checkCredentials($credentials, UserInterface $user)
    {
        dd('Checking credentials');
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
    {
        // todo
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey)
    {
        // todo
    }

    public function start(Request $request, AuthenticationException $authException = null)
    {
        // todo
    }

    public function supportsRememberMe()
    {
        // todo
    }
}
