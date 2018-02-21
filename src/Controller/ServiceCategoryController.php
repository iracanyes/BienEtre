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
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


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

    public function createAction(Request $request): Response
    {
        $em = $this->getDoctrine()->getManager();

        $serviceCategory = new ServiceCategory();

        $form = $this->createForm(ServiceCategoryType::class, $serviceCategory);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $newServiceCategory = $form->getData();

            // test d'existence de la catégorie
        }
    }

}