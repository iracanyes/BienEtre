<?php
/**
 * Created by PhpStorm.
 * User: isk
 * Date: 20.11.17
 * Time: 19:04
 */

namespace App\Controller;

use App\Entity\ServiceCategory;
use App\Form\ServiceCategoryType;
use Doctrine\ORM\EntityNotFoundException;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;


class ServiceCategoryController extends Controller
{
    /**
     * Route Service Category List
     *
     * @Route("/categories", name="service_category_list")
     */
    public function indexAction(Request $request): Response
    {
        $em = $this->getDoctrine();
        $categories = $em->getRepository("App:ServiceCategory");

        return $this->render(
            "superlist/public/serviceCategory/service-category-listing-detail.html.twig"
        );
    }

    /**
     * Route ServiceCategory Detail
     * @Route("/categories/{slug}", name="service_category_detail")
     */
    public function showAction(Request $request): Response
    {
        /**
         * Récupération de paramètre de requête
         */
        $slug = $request->attributes->get("slug") ?? null;

        $em = $this->getDoctrine();

        if(is_string($slug)){
            $serviceCategory = $em->getRepository("App:ServiceCategory")
                    ->findCategoryAndProvidersBySlug($slug);
        }

        if(!$serviceCategory){
            throw $this->createNotFoundHttpException("La catégorie de service recherché ".$slug."\n n'est pas présente dans la DB!");
        }

        return $this->render(
            "superlist/public/serviceCategory/service-category-listing-detail.html.twig",
            array("serviceCategory"=>$serviceCategory)
        );
    }


    /**
     * @Route("/profile/category", name="profile_service_category_list")
     * @Security("is_granted('ROLE_PROVIDER')", message="Authentification requis!")
     */
    public function listAction(Request $request): Response
    {
        $em = $this->getDoctrine()->getManager();

        $user = $this->getUser();

        try{

            $serviceCategories = $em->getRepository("App:ServiceCategory")
                ->findByProviderId($user->getId());

        }catch (EntityNotFoundException $e){

            $this->addFlash("warning", "Erreur survenue!");

            $this->forward("App\Controller\ProfileController::homeAction");

        }

        if(!$serviceCategories){

            $this->addFlash(
                "warning",
                "Aucune catégorie de service n'enregistré pour vous!
                 Définitions de catégorie de services obligatoire pour la création de service!"
            );

        }

        return $this->render(
            "superlist/profile/service-category/list.html.twig",
            array(
                "serviceCategories" => $serviceCategories,
                "user" => $user
                )
        );
    }

    /**
     * @Route("/profile/category/new", name="service_category_add")
     * @Security("is_granted('ROLE_PROVIDER')", message="Authentification requis!")
     * @param Request $request
     * @return Response
     */
    public function addAction(Request $request): Response
    {
        $em = $this->getDoctrine()->getManager();

        $serviceCategory = new ServiceCategory();

        $form = $this->createForm(ServiceCategoriesType::class, $serviceCategory);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $newServiceCategory = $form->getData();

            // test d'existence de la catégorie

            $serviceCategory = $form->getData();

            $em->persist($serviceCategory);
            $em->flush();

            $this->addFlash("success", "Ajout de la catégorie de service '".$serviceCategory->getName()."' a été effectué avec succés! ");

            $this->forward("App\Controller\ServiceCategoryController::listAction");

        }

        dump($this->getUser());

        return $this->render(
            "superlist/profile/service-category/add.html.twig",
            array(
                "form" => $form->createView(),
                "user" => $this->getUser()
            )
        );
    }

}