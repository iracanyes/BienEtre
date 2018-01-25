<?php
/**
 *
 * User: Iracanyes
 * Description: Token Authenticator
 * Cette classe permettra d'authentifié le header "X-AUTH-TOKEN" de chaque requête qui contient les infos de sécurité de connection de chaque utilisateur.
 * Date: 18.01.18
 * Time: 22:25
 */

namespace App\Security;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Guard\AbstractGuardAuthenticator;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class TokenAuthenticator extends AbstractGuardAuthenticator
{
    /**
     * Cette méthode sera appelé à chaque requête pour déterminer si cette classe d'authentification devrait être utilisé pour cette requête
     */
    public function supports(Request $request)
    {
        return $request->headers->has("X-AUTH-TOKEN");
    }

    /**
     * Appelé à chaque requête. Retourne les identifiants(credentials) que l'on veut passer à la méthode getUser()
     */
    public function getCredentials(Request $request)
    {
        // On définit les éléments à
        return array(
            "token" => $request->headers->get('X-AUTH-TOKEN'),
        );
    }

    public function getUser($credentials, UserProviderInterface $userProvider)
    {
        // TODO: Implement getUser() method.
    }

    public function checkCredentials($credentials, UserInterface $user)
    {
        // TODO: Implement checkCredentials() method.
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
    {
        // TODO: Implement onAuthenticationFailure() method.
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey)
    {
        // TODO: Implement onAuthenticationSuccess() method.
    }

    public function supportsRememberMe()
    {
        // TODO: Implement supportsRememberMe() method.
    }

    public function start(Request $request, AuthenticationException $authException = null)
    {
        // TODO: Implement start() method.
    }


}