<?php
/**
 * Created by PhpStorm.
 * User: isk
 * Date: 20.11.17
 * Time: 19:04
 */

namespace App\Controller;

use App\Entity\ServiceCategory;
use App\Form\CategoryType;
use App\Form\ServiceCategoryType;
use Doctrine\Common\CommonException;
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

        $form = $this->createForm(CategoryType::class, $serviceCategory);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $newServiceCategory = $form->getData();

            // test d'existence de la catégorie

            $serviceCategory = $form->getData();

            $serviceCategory->addProvider($this->getUser());

            $em->persist($serviceCategory);
            $em->flush();

            $this->addFlash("success", "Ajout de la catégorie de service '".$serviceCategory->getName()."' a été effectué avec succés! ");

            $this->redirectToRoute("profile_edit_home");

        }

        $categories = $em->getRepository("App:Provider")
            ->getCategories($this->getUser()->getId());

        dump($this->getUser()->getId());
        dump($categories);

        if(!$categories){
            $this->addFlash("no_categories","Aucune catégorie de service enregistré pour vous !");
        }

        return $this->render(
            "superlist/profile/service-category/add.html.twig",
            array(
                "form" => $form->createView(),
                "user" => $this->getUser(),
                "categories" => $categories
            )
        );
    }

    /**
     * @Route("/profile/category/update", name="service_category_update")
     * @Security("is_granted('ROLE_PROVIDER')", message="Authentification requis!")
     * @param Request $request
     * @return Response
     */
    public function updateAction(Request $request): Response
    {
        $em = $this->getDoctrine()->getManager();

        $category  = $em->getRepository("App:ServiceCategory")
            ->find($request->query->get("id"));

        $form = $this->createForm(CategoryType::class, $category);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $category = $form->getData();

            try{
                $em->persist($category);

                $em->flush();

                $this->addFlash("success", "Modification enregistré avec succés!");

                $this->redirectToRoute("profile_edit_home");

            }catch (CommonException $e){

                $this->addFlash("warning", "Erreur lors de la mise à jour!");
            }

            $this->redirectToRoute("profile_edit_home");
        }

        return $this->render(
            "superlist/profile/service-category/update.html.twig",
            array(
                "form" => $form->createView(),
                "user" => $this->getUser(),
                "category" => $category
            )
        );
    }


    /**
     * @Route("/profile/category/delete", name="service_category_delete")
     * @Security("is_granted('ROLE_PROVIDER')", message="Authentification requis!")
     * @param Request $request
     * @return Response
     */
    public function deleteAction(Request $request): Response
    {
        $em = $this->getDoctrine()->getManager();

        $category = $em->getRepository("App:ServiceCategory")
            ->find($request->query->get("id"));

        try{

            $em->remove($category);

            $em->flush();

            $this->addFlash("success","Suppression confirmé!");

            $this->redirectToRoute("profile_edit_home");

        }catch (CommonException $e){

            $this->addFlash("warning", "Une erreur est survenue durant la suppression de la catégorie!");
        }


    }

}