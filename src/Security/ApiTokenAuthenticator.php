<?php

namespace App\Security;

use App\Repository\ApiToeknRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
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
            throw new CustomUserMessageAuthenticationException('Invalid API token');
        }

        if($token->isExpired()) {
            throw new CustomUserMessageAuthenticationException('Token has expired');
        }

        return $token->getUser();
    }

    public function checkCredentials($credentials, UserInterface $user)
    {
        return true;
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
    {
        return new JsonResponse([
            'message' => $exception->getMessage(),
        ], 401);
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey)
    {
        // allow the request to continue
    }

    public function start(Request $request, AuthenticationException $authException = null)
    {
        throw new CustomUserMessageAuthenticationException('Not used: entry_point from other authenticator is used');
    }

    public function supportsRememberMe()
    {
        return false;
    }
}
