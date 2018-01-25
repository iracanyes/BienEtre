<?php
/**
 * Created by PhpStorm.
 * User: isk
 * Date: 12.12.17
 * Time: 19:16
 */
namespace App\Security;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use App\Form\UserType;

class SecurityController extends Controller
{
    /**
     * @Route("/login", name="login")
     *
     * @return Response
     */
    public function loginAction(Request $request, AuthenticationUtils $authenticationUtils): Response
    {
        $authenticationUtils = $this->get("security.authentication_utils");

        /*
         * Récupération des informations de connexion en cas d'erreur
         */
        $error = $authenticationUtils->getLastAuthenticationError();

        /**
         * Récupération du identifiant de connexion
         */
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render(
            "security/login.html.twig",
            array(
                "last_username" => $lastUsername,
                "error" => $error
            )
        );


    }



}