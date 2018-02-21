<?php
/**
 * Created by PhpStorm.
 * User: isk
 * Date: 20.02.18
 * Time: 01:37
 */

namespace App\Controller;

use App\Form\PromotionType;
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
     * @Route("/profile/promotions", name="profile_promotion_list")
     * @ Security("is_granted('ROLE_PROVIDER')
     */
    public function listAction(Request $request):Response
    {
        // Entity Manager
        $em = $this->getDoctrine()->getManager();

        try{
            // promotion existant
            $promotions = $em->getRepository("App:Promotion")
                ->findAllByProviderId($this->getUser()->getId());

        }catch (EntityNotFoundException $e){

            $this->addFlash("warning", "Aucune promotion ne correspond à cette ID");

            $this->redirectToRoute("profile_home");
        }

        $this->render(
            "superlist/admin/promotion/list.html.twig",
            array(
                "promotions" => $promotions
            )
        );
    }

    /**
     * @Route("/profile/edit/promotion/{id}", name="promotion_detail")
     * @param Request $request
     * @return Response
     *
     */
    public function showAction(Request $request):Response
    {
        $em = $this->getDoctrine()->getManager();

        $id = $request->query->get("id");

        try{

            $promotions = $em->getRepository("App:Promotion")
                ->find($id);

        }catch (EntityNotFoundException $e){

            $this->addFlash("warning","Aucune promotion ne correspond à cette id");

            $this->redirectToRoute("profile_promotion_list");
        }

        $this->render(
            "superlist/admin/promotion/list.html.twig"
        );


    }


    /**
     * @Route("/profile/promo/update/{id}", name="promotion_update")
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

}