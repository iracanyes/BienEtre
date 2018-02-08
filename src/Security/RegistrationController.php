<?php
/**
 * Created by PhpStorm.
 * User: isk
 * Date: 13.01.18
 * Time: 12:23
 */

namespace App\Security;

use App\Entity\Client;
use App\Entity\Provider;
use App\Form\ClientType;
use App\Form\ProviderType;
use App\Security\User\UserConverter;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use App\Form\UserTempType;
use App\Entity\UserTemp;
use Symfony\Component\Security\Core\Exception\BadCredentialsException;
use Symfony\Component\Security\Core\Exception\InvalidCsrfTokenException;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;

class RegistrationController extends Controller
{
    /**
     * @param Request $request
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @param SessionInterface $session
     * @param \Swift_Mailer $mailer
     * @return RedirectResponse|Response
     */
    public function signInAction(Request $request, UserPasswordEncoderInterface $passwordEncoder, SessionInterface $session, \Swift_Mailer $mailer)
    {

        // Entity Manager
        $em = $this->getDoctrine()->getManager();

        // Création d'un formulaire à partir de l'objet vide
        $userTemp = new UserTemp();
        $form = $this->createForm(UserTempType::class, $userTemp);

        // hydratation de l'objet ac les données de la soumission du formulaire
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){



            /* test d'authenticité du token CSRF = PAS NECESSAIRE CAR GÉRER PAR LE COMPOSANT DE FORMULAIRE
             * Nécessaire dans le cas de création de formulaire
             * $submittedToken = $request->request->get("_csrf_token");
             *   dump($submittedToken);
             *   die();
             *   if(!$this->isCsrfTokenValid("email", $submittedToken)){
             *       throw new InvalidCsrfTokenException("Le token est invalide!");
             *   }
             */

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
         * Générer une route pour la connexion de confirmation
         */
            $url = $this->generateUrl(
                "signin_confirmation",
                array("token" => $userTemp->getToken())
            );
            /*
             * Créer le template Twig du message
             * et charger le template dans une variable
             */

            $message = (new \Swift_Message("Confirmation inscription"))
                ->setTo($userTemp->getEmail())
                ->setFrom('no-reply@bien-etre.com')
                ->setBody(
                    $this->renderView(
                    // template d'email
                        "emails/registration.html.twig",
                        array(
                            "user"=> $userTemp,
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

            $mailer->send($message);

            /*
             * Message de confirmation de l'inscription
             * raccourci pour $request->getSession()->getFlashBag()->add("type_message", "mon message");
             */
            $this->addFlash(
                "success",
                "L'inscription est enregistré. Consultez votre adresse e-mail pour confirmer votre inscription."
            );

            /* Redirection vers la page de confirmation d'inscription par e-mail
             * Attention: Créer un formulaire pour ajouter le token reçu par e-mail avant de voir
             * le formulaire de confirmation
             */
            return $this->redirectToRoute("homepage");
        }

        // Affichage du formulaire d'inscription
        return $this->render(
            "security/register.html.twig",
            array("form" => $form->createView())
        );
    }

    /**
     * @Route("/signin_confirmation", name="signin_confirmation")
     * @param Request $request
     */
    public function confirmationAction(Request $request, SessionInterface $session, UserConverter $converter)
    {
        // Entity Manager
        $em = $this->getDoctrine()->getManager();

        // Extraction du token de l'URL
        $token = $request->query->get("token");


        if(empty($token)){
            throw new BadCredentialsException("La voie du milieu est semé d'embuche!");
        }

        // Récupération de l'entité
        // Attention findByX retourne un array de résultat tandis que findOneByX retourne un objet ou null
        $userTemp = $em->getRepository("App:UserTemp")
            ->findOneByToken($token);



        if(!$userTemp){
            throw new UsernameNotFoundException(sprintf("Aucun utilisateur ne posséde un token d'inscription équivalent à %s", $token));
        }

        // Transfert des infos en fonction du type d'utilisateur, dans un objet de type Client et Provider

        if($userTemp->getUserType() == "provider"){

            $provider = $converter->convertToProvider($userTemp);

            if($provider instanceof Provider){

                // Ajout du nouveau role
                $provider->addRole("ROLE_PROVIDER");

                // Création du formulaire
                $form = $this->createForm(ProviderType::class, $provider);
            }



        }else{
            $client = $converter->convertToClient($userTemp);

            if($client instanceof Client){

                // Ajout du nouveau rôle
                $client->addRole("ROLE_CLIENT");

                // Création du formulaire
                $form = $this->createForm(ClientType::class, $client);
            }
        }

        // Gestion de la soumission d'un formulaire en fonction du type
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

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
            array(
                "form" => $form->createView(),
                "userType" => $userTemp->getUserType()
            )
        );
    }

}
