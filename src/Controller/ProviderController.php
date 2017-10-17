<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

/**
 * Description of ProviderController
 *
 */
class ProviderController extends Controller
{
    /**
     * Route interne /providers
     * 
     * @Route("/providers", name="providers_list")
     */
    public function indexAction(): Response
    {
        $em = $this->get('doctrine.orm.entity_manager');

        $providers = $em->getRepository('App:Provider')
            ->findAll();

        if(!$providers){
            throw new NotFoundHttpException("Aucun prestataire enregistré!");
        }

        return $this->render(
            'superlist/provider/provider-boxed.html.twig',
            array('providers'=> $providers)
        );
    }  
    
    /**
     * Route /blog/*
     * 
     * @Route("/providers/{slug}", name="provider_detail")
     */
    public function showAction(Request $request)
    {
        $em = $this->get("doctrine.orm.entity_manager");

        $slug = $request->attributes->get("slug");

        $provider = $em->getRepository('App:Provider')
            ->findBySlug($slug);

        if(!$provider){
            throw new NotFoundHttpException("Le prestataire ".$slug." n'existe pas");
        }

        return $this->render(
            "superlist/provider/provider-detail.html.twig",
            array("provider"=>$provider)
        );
    }        
}
