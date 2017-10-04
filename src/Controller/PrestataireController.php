<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

/**
 * Description of PrestataireController
 *
 * @author isk
 */
class PrestataireController extends Controller
{
    /**
     * Route interne /prestataire
     * 
     * @Route("/prestataire", name="prestataire_list")
     */
    public function indexAction(): Response
    {
    }  
    
    /**
     * Route /blog/*
     * 
     * @Route("/prestataire/{slug}", name="prestataire_show")
     */
    public function showAction($slug)
    {
        
    }        
}
