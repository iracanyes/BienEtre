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
     * @Route("/services/{slug}", name="service_detail")
     *
     * @param Request $request
     */
    public function showAction(Request $request)
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