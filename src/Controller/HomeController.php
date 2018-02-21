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
        $em = $this->getDoctrine()->getManager();


        $providers = $em->getRepository("App:Provider")
            ->findAll();



        // Slider d'image des catégories de services fournis par le site
        $serviceCategories = $em->getRepository("App:ServiceCategory")
            ->findAll();

        /* Pour tester les valeurs retournés par une variable, on peut utiliser la méthode
            dump(var) pour afficher les valeurs dans le navigateurs
            die($message) permet de sortir de l'exécution du script

        var_dump($serviceCategories);
        die();
        */

        $services = $em->getRepository("App:Service")
            ->recentServices();


        // Promotions récentes : OK
        $promotions = $em->getRepository("App:Promotion")
            ->recentPromotions();
        // Provider classé par nombre de fans.
        $bestProviders = $em->getRepository("App:Provider")
            ->mostFans(4);

        // Recent comments
        $recentComments = $em->getRepository("App:Comment")
            ->recentComments();

        // Expiring promotions
        $expiringPromotions = $em->getRepository("App:Promotion")
            ->expiringPromotions();

        // Catégorie de service et providers
        $serviceCategoriesPlusProviders = $em->getRepository("App:ServiceCategory")
            ->getServiceCategoriesAndProviders();




        if(!$providers){
            throw new NotFoundHttpException("Aucun provider enregistré en DB! ");
        }



        if(!$bestProviders){
            throw new NotFoundHttpException("Aucun vote pour un prestataire n'a été effectué!");
        }

        if(!$recentComments){
            throw new NotFoundHttpException("Aucun commentaire pour un prestataire n'a été effectué!");
        }

        if(!$expiringPromotions){
            throw new NotFoundHttpException("Aucun promotion en cours d'expiration n'est présent!");
        };

        if(!$serviceCategoriesPlusProviders){
            throw new NotFoundHttpException("Aucune catégorie de service n'est présente!");
        }


        return $this->render(
            "superlist/public/index.html.twig",
            array(
                "providers" => $providers,
                "services" => $services,
                "serviceCategories" => $serviceCategories,
                "promotions" => $promotions,
                "bestProviders" => $bestProviders,
                "recentComments" => $recentComments,
                "expiringPromotions" =>$expiringPromotions,
                "serviceCategoriesPlusProviders" => $serviceCategoriesPlusProviders
            )
        );
    }

    /**
     * @Route("/contact", name="contact")
     */
    public function getContactPage(): Response
    {
        return $this->render('superlist/public/contact.html.twig');
    }
}
