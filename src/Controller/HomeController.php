<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of HomeController
 *
 * @author isk
 */

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class HomeController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function index(): Response
    {
        $em = $this->getDoctrine()->getEntityManager();

        $providers = $em->getRepository("App:Provider")
            ->findAll();

        // Information pour la barre de recherche
        $townships = $em->getRepository("App:Township")
            ->findAll();
        $localities = $em->getRepository("App:Locality")
            ->findAll();
        $postalCodes = $em->getRepository("App:PostalCode")
            ->findAll();

        // Slider d'image des catégories de services fournis par le site
        $serviceCategories = $em->getRepository("App:ServiceCategory")
            ->findAll();

        // Services récents : DQL à faire
        $services = $em->getRepository("App:Service")
            ->findAll();

        // Promotions récentes : DQL à faire
        $promotions = $em->getRepository("App:Promotion")
            ->recentPromotions();


        if(!$providers){
            throw new NotFoundHttpException("Aucun provider enregistré en DB! ");
        }

        if(!$townships){
            throw new NotFoundHttpException("Aucune ville n'est enregistré en DB!");
        }

        if(!$localities){
            throw new NotFoundHttpException("Aucune localité n'est enregistré en DB!");
        }

        if(!$postalCodes){
            throw new NotFoundHttpException("Aucune code postal n'est enregistré en DB!");
        }


        return $this->render(
            "superlist/index.html.twig",
            array(
                "providers" => $providers,
                "townships" => $townships,
                "localities" => $localities,
                "postalCodes" => $postalCodes,
                "services" => $services,
                "serviceCategories" => $serviceCategories,
                "promotions" => $promotions
            )
        );
    }            
}
