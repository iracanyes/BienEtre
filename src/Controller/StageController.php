<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;



class StageController extends Controller
{
    /**
     * @Route("/services", name="services_list")
     */
    public function index()
    {
        $em = $this->get("doctrine.orm.entity_manager");

        $services = $em->getRepository('App\Entity\Stage')
            ->findAll();

        if(!$services){
            throw new NotFoundHttpException("Aucun service enregistré en DB!");
        }

        return $this->render(
            "templates:views:service:service-boxed.html.twig",
            array("services"=>$services)
        );
    }

}