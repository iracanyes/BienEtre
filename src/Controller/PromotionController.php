<?php
/**
 * Created by PhpStorm.
 * User: isk
 * Date: 20.02.18
 * Time: 01:37
 */

namespace App\Controller;

use App\Entity\Promotion;
use App\Form\PromotionType;
use Doctrine\Common\CommonException;
use Doctrine\ORM\Persisters\PersisterException;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Doctrine\ORM\EntityNotFoundException;

class PromotionController extends Controller
{
    /**
     * @Route("/promo", name="promotion_list")
     * @param Request $request
     * @return Response
     */
    public function indexAction(Request $request):Response
    {
        // Entity Manager
        $em = $this->getDoctrine()->getManager();

        try{
            // promotion existant
            $promotions = $em->getRepository("App:Promotion")
                ->findAll();

        }catch (EntityNotFoundException $e){

            $this->addFlash("warning", "Aucune promotion ne correspond à cette ID");

            $this->redirectToRoute("profile_home");
        }

        dump($this->getUser());

        $this->render(
            "superlist/public/promotion/list.html.twig",
            array(
                "promotions" => $promotions
            )
        );
    }

    /**
     * @Route("/promo/{slug}", name="promotion_detail")
     * @param Request $request
     * @return Response
     *
     */
    public function showAction(Request $request):Response
    {
        $em = $this->getDoctrine()->getManager();

        $id = $request->query->get("slug");

        try{

            $promotion= $em->getRepository("App:Promotion")
                ->findBySlug($slug);

        }catch (EntityNotFoundException $e){

            $this->addFlash("warning","Aucune promotion ne correspond à cette id");

            $this->redirectToRoute("profile_promotion_list");
        }

        $this->render(
            "superlist/admin/promotion/list.html.twig"
        );


    }

    /**
     * @Route("/profile/promo", name="profile_promotion_list")
     * @Security("is_granted('ROLE_PROVIDER')", message="Authentification requis!")
     */
    public function listAction(Request $request): Response
    {
        $em = $this->getDoctrine()->getManager();

        $pendingPromotions = $em->getRepository("App:Promotion")
            ->findPendingByProviderId($this->getUser()->getId());

        $ongoingPromotions = $em->getRepository("App:Promotion")
            ->findOngoingByProviderId($this->getUser()->getId());

        $expiredPromotions = $em->getRepository("App:Promotion")
            ->findExpiredByProviderId($this->getUser()->getId());

        if(!$pendingPromotions){
            $this->addFlash("warning_pending", "Aucune promotion en attente pour vous!");
        }

        if(!$ongoingPromotions){
            $this->addFlash("warning_ongoing", "Aucune promotion en cours pour vous!");
        }

        if(!$expiredPromotions){
            $this->addFlash("warning_expired", "Aucune promotion expirée pour vous!");
        }

        dump($pendingPromotions);

        dump($ongoingPromotions);

        dump($expiredPromotions);

        return $this->render(
            "superlist/profile/promotion/list.html.twig",
            array(
                "pendingPromotions" => $pendingPromotions,
                "ongoingPromotions" => $ongoingPromotions,
                "expiredPromotions" => $expiredPromotions,
                "user" => $this->getUser()
            )
        );
    }


    /**
     * @Route("/profile/promo/update", name="promotion_update")
     * @ Security("is_granted('ROLE_PROVIDER')
     */
    public function updateAction(Request $request):Response
    {
        // Entity Manager
        $em = $this->getDoctrine()->getManager();

        // Attention validé l'input
        $id = $request->query->get("id");
        try{
            // promotion existant
            $promotion = $em->getRepository("App:Promotion")
                ->find($id);
        }catch (EntityNotFoundException $e){

            $this->addFlash("warning", "Aucune promotion ne correspond à cette ID");

            $this->redirectToRoute("profile_home");
        }


        //Création du formulaire
        $form = $this->createForm(PromotionType::class, $promotion);

        // gestion soumission du formulaire
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $promotion = $form->getData();

            dump($this->getUser());

            $promotion->setProvider($this->getUser());

            $em->persist($promotion);
            $em->flush();

            $this->addFlash("success","Modifications enregistrés!");

            $this->redirectToRoute("profile_promotions_list");
        }

        $this->render(
            "superlist/admin/promotion-list.html.twig",
            array(
                "form" => $form->createView()
            )
        );
    }

    /**
     * @Route("/profile/promo/new", name="promotion_add")
     * @Security("is_granted('ROLE_PROVIDER')", message="Authentification requis!")
     */
    public function addAction(Request $request): Response
    {
        $em = $this->getDoctrine()->getManager();

        $promo = new Promotion();

        $form = $this->createForm(PromotionType::class, $promo);

        $form->handleRequest($request);

        if($form->isSubmitted() &&  $form->isValid()){

            $promo = $form->getData();

            dump($promo);
            // Association du prestataire à la promotion créée
            $promo->setProvider($this->getUser());

            try{
                $em->persist($promo);

                $em->flush();
            }catch (PersisterException $e){

                $this->addFlash("warning","Une erreur est survenue durant l'enregistrement, veuillez ré-essayer ou contacter nous pour plus d'aide!");

                return $this->render(
                    "superlist/profile/promotion/add.html.twig",
                    array("form"=> $form->createView())
                );
            }

            $this->addFlash("success","La promotion '".$promo->getName()."'' a été enregistré avec succés!");

            return $this->redirectToRoute("profile_promotion_list");



        }

         $promotions = $em->getRepository("App:Promotion")
             ->findByProviderId($this->getUser()->getId());

        return $this->render(
            "superlist/profile/promotion/add.html.twig",
            array(
                "form"=> $form->createView(),
                "user" => $this->getUser(),
                "promotions" => $promotions
            )
        );
    }

    /**
     * @Route("/profile/promo/delete", name="promotion_delete")
     * @Security("is_granted('ROLE_PROVIDER')", message="Authentification requis!")
     * @param Request $request
     * @return Response
     */
    public function deleteAction(Request $request): Response
    {
        $em = $this->getDoctrine()->getManager();

        $id = $request->query->get("id");



        try{
            $promo = $em->getRepository("App:Promotion")
                ->find($id);

            $em->remove($promo);

            $em->flush();

            $this->addFlash("success","Service supprimé!");


        }catch (EntityNotFoundException $e){

            $this->addFlash("warning","Aucun service ne correspond à cette ID");
         /* Vérifier les exceptions lancés lors de la suppression d'une entité */
        }catch (CommonException $e){


            $this->addFlash("warning","Impossible de supprimer ce service! Contacter l'administrateur du site.");
        }




    }

}