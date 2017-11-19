<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;



class ServiceController extends Controller
{
    /**
     *
     * @Route("/services", name="service_list")
     */
    public function indexAction(): Response
    {
        $em = $this->get("doctrine.orm.entity_manager");

        $services = $em->getRepository('App:Service')
            ->findAll();

        if(!$services){
            throw new NotFoundHttpException("Aucun service enregistré en DB!");
        }

        return $this->render(
            "superlist/service/service-boxed.html.twig",
            array("services"=>$services)
        );
    }



    /**
     * Route Service - Search Map
     * @Route("/services/search", name="service_search")
     *
     * @param Request $request
     * @return Response
     *
     */
    public function searchAction(Request $request): Response
    {
        /**
         * Récupération des paramètres de recherche
         */
        $locality = $request->request->get("locality") ? $request->request->get("locality") : null;
        $postalCode = $request->request->get('postalCode') ?? null;
        $township = $request->request->get("township") ?? null ;

        /**
         * Données du formulaire de recherche
         */
        $em = $this->getDoctrine();

        $localities = $em->getRepository('App:Locality')
            ->findAll();
        $townships = $em->getRepository('App:Township')
            ->findAll();
        $postalCodes = $em->getRepository("App:PostalCode")
            ->findAll();

        /**
         * Résultat de recherche
         */

        $services = $em->getRepository("App:Service")
            ->searchBy(
                array(
                    "locality"=> $locality,
                    "postalCode" => $postalCode,
                    "township" => $township
                )
            );


        if(!$localities){
            throw $this->createNotFoundException("Aucune localité trouvé en DB!");
        }

        if(!$townships){
            throw $this->createNotFoundException("Aucune ville trouvé en DB!");
        }

        if(!$postalCodes){
            throw $this->createNotFoundException("Aucun code postal trouvé en DB!");
        }

        return $this->render(
            'superlist/service/service-search-map.html.twig',
            array(
                'localities' => $localities,
                "townships" => $townships,
                "postalCodes" => $postalCodes,
                "services" => $services
            )
        );

    }

    /**
     * @Route("/services/{slug}", name="service_detail")
     *
     * @param Request $request
     * @return Response
     */
    public function showAction(Request $request): Response
    {
        $em = $this->get("doctrine.orm.entity_manager");

        // Élement à vérifier avec regEx
        $slug = $request->attributes->get('slug');

        $service = $em->getRepository("App:Service")
            ->findOneBySlug($slug);

        if(!$service){
            throw new NotFoundHttpException("Aucun service n'est enregistré en DB!");
        }

        return $this->render(
            "superlist/service/service-detail.html.twig",
            array("service"=> $service)
        );
    }
}