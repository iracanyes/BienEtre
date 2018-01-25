<?php
/**
 * Created by PhpStorm.
 * User: isk
 * Date: 17.10.17
 * Time: 13:47
 */
namespace App\Email;

use App\Entity\UserTemp;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
/**
 * Class UserMailer
 * @package App\Email
 *
 * Service d'envoie d'e-mail lié aux utilisateurs.
 */
class UserMailer
{
    /**
     * @var \Swift_Mailer
     */
    protected $mailer;

    /**
     * @var UrlGeneratorInterface
     */
    protected $router;

    public function __construct(\Swift_Mailer $mailer, UrlGeneratorInterface $urlGenerator)
    {
        $this->mailer = $mailer;
        $this->router= $urlGenerator;
    }

    /**
     * Envoie un email de confirmation à l'utilisateur
     *
     * @param UserTemp $user
     */
    public function sendConfirmation(UserTemp $user)
    {
        /*
         * Générer une route pour la connexion de confirmation
         */
        $url = $this->router->generate(
            "registration_confirmed",
            array("token" => $user->getToken())
        );
        /*
         * Créer le template Twig du message
         * et charger le template dans une variable
         */

        $message = new \Swift_Message("Confirmation inscription");

        $message->setTo($user->getEmail())
                ->setFrom('no-reply@bien-etre.com')
                ->setBody(
                    $this->renderView(
                        // template d'email
                        "emails/registration.html.twig",
                        array(
                            "user"=> $user,
                            "url" => $url
                        )
                    ),
                    "text/html"
                );
        /*
         * Si l'on veut inclur un version texte du message
         * ->addpart(
         *      $this->renderView(
         *          "emails/registration.html.twig",
         *          array("name" => $name)
         *      ),
         *      "text/plain"
         * )
         */
        $this->mailer->send($message);
    }
}