<?php
/**
 * Created by PhpStorm.
 * User: isk
 * Date: 13.01.18
 * Time: 12:23
 */

namespace App\Controller;

use App\Entity\Client;
use App\Entity\Provider;
use App\Form\ClientType;
use App\Form\ProviderType;
use App\Security\User\UserConverter;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use App\Form\UserTempType;
use App\Entity\UserTemp;
use Symfony\Component\Security\Core\Exception\BadCredentialsException;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;

class RegistrationController extends Controller
{
    /**
     * @Route("/signin", name="user_signin")
     */
    public function signInAction(Request $request, UserPasswordEncoderInterface $passwordEncoder, SessionInterface $session)
    {
        $em = $this->getDoctrine()->getManager();

        // Création d'un formulaire à partir de l'objet vide
        $userTemp = new UserTemp();
        $form = $this->createForm(UserTempType::class, $userTemp);

        // hydratation de l'objet ac les données de la soumission du formulaire
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            // Récupération de l'objet après hydratation
            $userTemp = $form->getData();

            // Ajout de la date de créeation
            $userTemp->setRegistryDate(new \DateTime());

            // Encodage du mot de passe(on peut aussi le faire via Doctrine Listener)
            $password = $passwordEncoder->encodePassword($userTemp, $userTemp->getPlainPassword());

            $userTemp->setPassword($password);

            // Effacement du mot de passe en clair
            $userTemp->eraseCredentials();

            // Création du token
            $userTemp->setToken(bin2hex(random_bytes(64)));

            /*
                Création d'une session authentifié à partir de l'email, le token et la date de création de l'objet

            */
            $session->set("user",$request->request->get("email") );

            //
            $session->set("token", $userTemp->getToken());

            // Sauvegarde temporaire du membre en DB

            $em->persist($userTemp);
            $em->flush();

            /*
             * Envoi d'un email de confirmation à l'adresse e-mail=> effectué par un Doctrine Event Listener
             */


            /*
             * Message de confirmation de l'inscription
             * raccourci pour $request->getSession()->getFlashBag()->add("type_message", "mon message");
             */
            $this->addFlash(
                "success",
                "L'inscription est enregistré. Consultez votre adresse e-mail pour confirmer votre inscription."
            );

            // Redirection vers la page de confirmation d'inscription par e-mail
            return $this->redirectToRoute("registration_confirmation");
        }

        // Affichage du formulaire d'inscription
        return $this->render(
            "security/register.html.twig",
            array("form" => $form->createView())
        );
    }

    /**
     * @Route("/confirmation/{token}", name="confirmation_signin")
     * @param Request $request
     */
    public function confirmation(Request $request, SessionInterface $session, UserConverter $converter)
    {
        // Entity Manager
        $em = $this->getDoctrine()->getManager();

        // Extraction du token de l'URL
        $token = $request->query->get("token");

        if(!$token){
            throw new BadCredentialsException();
        }

        // Récupération de l'entité
        $userTemp = $em->getRepository("App:UserTemp")
            ->loadUserTempByToken($token);

        if(!$userTemp){
            throw new UsernameNotFoundException(sprintf("Aucun utilisateur ne posséde un token d'inscription équivalent à %s", $token));
        }

        // Transfert des infos en fonction du type d'utilisateur, dans un objet de type Client et Provider

        if($userTemp->getUserType() === "provider"){

            $provider = $converter->convertToProvider($userTemp);

            if($provider instanceof Provider){
                $form = $this->createForm(ProviderType::class, $provider);
            }

        }else{
            $client = $converter->convertToClient($userTemp);

            if($client instanceof Client){

                $form = $this->createForm(ClientType::class, $client);
            }
        }

        // Gestion de la soumission d'un formulaire en fonction du type
        $form->handleRequest($request);

        if($form->isValid() && $form->isSubmitted()){

            $newUser = $form->getData();

            // A mettre en événement Doctrine
            $newUser->setRegistryDate(new \DateTime());

            // Création d'un nouveau token d'identification
            $newUser->setToken(bin2hex(random_bytes(64)));


            // Enregistrement du nouvel utilisateur
            $em->persist($newUser);
            $em->flush();

            // Démarrage d'une session authentifié
            $session->set("username", $newUser->getUsername());
            $session->set("token", $newUser->getToken());

            // Redirection vers le controller d'accueil des membres
            return $this->forward("App\Controller\ProfileController::homeAction", array("newUser"=> $newUser));
        }

        return $this->render(
            "security/confirmation.html.twig",
            array("form" => $form->createView())
        );
    }

}