<?php
/**
 * Created by PhpStorm.
 * User: isk
 * Date: 26.01.18
 * Time: 13:11
 */

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class SearchController extends Controller
{
    public function showAction(){

        //Entity Manager
        $em = $this->getDoctrine()->getManager();

        /**
         * Information pour la barre de recherche (créer un service gérant la recherche )
         * Créer un controller qui se chargera des requêtes de recherche et
         * un service qui s'occupera d'effectuer les recherches en BD.
         */
        $townships = $em->getRepository("App:Township")
            ->findAll();
        $localities = $em->getRepository("App:Locality")
            ->findAll();
        $postalCodes = $em->getRepository("App:PostalCode")
            ->findAll();

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
            "forms/public/search-home.html.twig",
            array(
                "localities" => $localities,
                "postalCodes" =>$postalCodes,
                "townships" => $townships
            )
        );
    }

    /**
     * @param Request $request
     * @Route("/search", name="search")
     */
    public function searchAction(Request $request)
    {

    }
}