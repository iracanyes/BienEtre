<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;



class ServiceController extends Controller
{
    /**
     * @Route("/services", name="services_list")
     */
    public function index()
    {
        $em = $this->get("doctrine.orm.entity_manager");

        $services = $em->getRepository('App\Entity\Service')
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
     * @Route("/services/{slug}", name="services_list")
     *
     * @param Request $request
     */
    public function showAction()
    {
        $em = $this->get("doctrine.orm.entity_manager");

        // Élement à vérifier avec regEx
        $slug = $this->attributes->get('slug');

        $services = $em->getRepository("App:Service")
            ->findOneBySlug($slug);

        if(!$services){
            throw new NotFoundHttpException("Aucun service n'est enregistré en DB!");
        }

        return $this->render("superlist/service/service-detail.html.twig");
    }
}