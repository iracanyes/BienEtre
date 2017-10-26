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

        if(!$providers){
            throw new NotFoundHttpException("Aucun provider enregistré en DB! ");
        }
        return $this->render(
            "superlist/index.html.twig",
            array("providers"=>$providers)
            );
    }            
}
