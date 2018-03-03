<?php
/**
 * Created by PhpStorm.
 * User: isk
 * Date: 19.12.17
 * Time: 19:28
 */

namespace App\Controller;

use App\Form\PwdType;
use Doctrine\Common\CommonException;
use Doctrine\ORM\ORMException;
use Doctrine\ORM\UnexpectedResultException;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use App\Form\UserType;
use App\Entity\User;

class ProfileController extends Controller
{

    /**
     * @Route("/profile", name="profile_home")
     * @Security("is_granted('ROLE_MEMBER')", message="Authentification requis!")
     */
    public function homeAction(Request $request, AuthorizationCheckerInterface $authChecker): Response
    {
        $em = $this->getDoctrine()->getManager();


        $user = $this->getUser();

        dump($user);

        return $this->render(
            "superlist/profile/profile-home.html.twig",
            array(
                "user"=> $user,
            )
        );
    }

    /**
     * @Route("/profile/edit", name="profile_edit_home")
     * @Security("is_granted('ROLE_PROVIDER')", message="Authentification requis!")
     * @param Request $request
     * @return Response
     */
    public function editHomeAction(Request $request): Response
    {
        $em = $this->getDoctrine()->getManager();

        $user = $this->getUser();

        try{
            $services = $em->getRepository("App:Service")
                ->findByProviderId($user->getId());

            $promotions = $em->getRepository("App:Promotion")
                ->findByProviderId($user->getId());

            $serviceCategories = $em->getRepository("App:ServiceCategory")
                ->findByProviderId($user->getId());

            dump($user->getId());
            dump($serviceCategories);

        }catch (UnexpectedResultException $e){

            $this->addFlash("warning","Une erreur est survenue durant le chargement! Ré-essayer ou contacter le support technique");

            $this->redirectToRoute("profile_home");
        }

        if(!$services){
            $this->addFlash("no_services", "Aucun service enregistré pour vous!");
        }

        if(!$promotions){
            $this->addFlash("no_promotions", "Aucune promotion enregistrée pour vous!");
        }

        if(!$serviceCategories){
            $this->addFlash("no_categories", "Aucune catégorie de service enregistré pour vous!");
        }

        return $this->render(
            "superlist/profile/profile-edit.html.twig",
            array(
                "user"=> $user,
                "services" => $services,
                "promotions" => $promotions,
                "serviceCategories" => $serviceCategories
            )
        );
    }



    /**
     * @Route("profile/update", name="profile_update")
     * @Security("is_granted('ROLE_PROVIDER')", message="Authentification requis!")
     */
    public function updateAction(Request $request)
    {
        if($this->getUser()->isProvider()){
            return $this->redirectToRoute("provider_update");
        }else{
            return $this->redirectToRoute("client_update");
        }
    }

    /**
     * @Route("/change_password", name="change_pwd")
     * @Security("is_granted('ROLE_PROVIDER')", message="Authentification requis")
     * @param Request $request
     *
     */
    public function changePwdAction(Request $request, UserPasswordEncoderInterface $passwordEncoder){

        $em = $this->getDoctrine()->getManager();

        $user = $this->getUser();

        $form = $this->createForm(PwdType::class, $user);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $user = $form->getData();

            // Encodage du mot de passe(on peut aussi le faire via Doctrine Listener)
            $password = $passwordEncoder->encodePassword($user, $user->getPlainPassword());

            $user->setPassword($password);

            // Effacement du mot de passe en clair
            $user->eraseCredentials();

            // Création du nouveau token
            $user->setToken(bin2hex(random_bytes(64)));

            try{

                $em->persist($user);
                $em->flush();
            }catch (CommonException $e){

                $this->addFlash("warning","Erreur durant la mise à jour du mot de passe!");

                return $this->redirectToRoute("profile_update");
            }
        }

        return $this->render(
            "superlist/profile/change-password.html.twig",
            array(
                "form" => $form->createView(),
            )
        );
    }

}