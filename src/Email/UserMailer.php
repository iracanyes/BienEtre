<?php
/**
 * Created by PhpStorm.
 * User: isk
 * Date: 17.10.17
 * Time: 13:47
 */
namespace App\Email;

use App\Entity\User;

/**
 * Class UserMailer
 * @package App\Email
 *
 * Service d'envoie d'e-mail lié aux utilisateurs.
 */
class UserMailer
{
    protected $mailer;

    public function __construct(\Swift_Mailer $mailer)
    {
        $this->mailer = $mailer;
    }

    /**
     * Envoie un email de confirmation à l'utilisateur
     *
     * @param User $user
     */
    public function sendConfirmation(User $user)
    {
        /*
         * Créer le template Twig du message
         * et charger le template dans une variable
         */
        $template = "";
        $message = new \Swift_Message($template);

        $message->addTo($user->email());
        $message->addFrom('admin@bien-etre.com');

        $this->mailer->send($message);
    }
}