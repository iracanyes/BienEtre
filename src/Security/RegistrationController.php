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
use Doctrine\ORM\Persisters\PersisterException;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Security\Core\Exception\BadCredentialsException;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use App\Form\UserTempType;
use App\Entity\UserTemp;

// Service d'Upload de fichier
use App\Service\Uploads\UploadFile;

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

        //dump($request->request->get('client'));

        //dump($request->files->get('url'));

        if(empty($token)){
            throw new BadCredentialsException("La voie du milieu est semé d'embuche!");
        }

        // Récupération de l'entité inscrit par son token
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
                $roles = $provider->getRoles();

                $roles[] = "ROLE_PROVIDER";

                dump($roles);
                dump($provider->getRoles());

                $provider->setRoles($roles);

                // Création du formulaire
                $form = $this->createForm(ProviderType::class, $provider);
            }



        }else{
            $client = $converter->convertToClient($userTemp);

            if($client instanceof Client){

                // Ajout du nouveau rôle
                $roles =$client->getRoles();

                $roles[] = "ROLE_CLIENT";

                $client->setRoles($roles);

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

            // Création d'un ID token d'identification et de l'api key
            $newUser->setToken(bin2hex(random_bytes(64)));
            $newUser->setApiKey(bin2hex(random_bytes(64)));

            // Activation du compte
            $newUser->setIsActive(true);
            $newUser->setNbErrorConnection(0);
            $newUser->setBanned(false);

            // Chargement des images de logo&Images pr le provider et Avatars pr le client



            try{
                // Enregistrement du nouvel utilisateur
                $em->persist($newUser);
                $em->flush();

            }catch(PersisterException $e){

                if($e){
                    throw $this->createAccessDeniedException(
                        "Code : \n"
                        .$e->getCode()
                        ."\n"
                        ."Fichier : \n"
                        .$e->getFile()
                        ."Message : \n"
                        .$e->getMessage()
                        ."\n"
                        .$e->getTraceAsString()
                    );
                }
            }


            //Message de confirmation de l'inscription
            $this->addFlash("success","Inscription terminée! Connectez-vous pour profitez de tous les avantages. ");

            // Redirection vers le controller d'accueil des membres
            return $this->forward("App\Security\SecurityController::loginAction");
        }

        return $this->render(
            "security/confirmation.html.twig",
            array(
                "form" => $form->createView(),
                "userType" => $userTemp->getUserType(),
                "token" => $userTemp->getToken()
            )
        );
    }

}
