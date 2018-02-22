<?php

namespace App\Controller;

use App\Entity\Provider;
use App\Entity\Service;
use App\Form\ServicesType;
use App\Form\ServiceType;
use Doctrine\ORM\Persisters\PersisterException;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Doctrine\ORM\UnexpectedResultException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;


class ServiceController extends Controller
{
    /**
     *
     * @Route("/services", name="service_list")
     * @return Response
     */
    public function indexAction(): Response
    {
        $em = $this->get("doctrine.orm.entity_manager");

        $services = $em->getRepository('App:Service')
            ->myFindAll();

        $recentServices = $em->getRepository("App:Service")
            ->recentServices();

        $serviceCategories = $em->getRepository("App:ServiceCategory")
            ->findAll();

        $localities = $em->getRepository("App:Locality")
            ->findAll();

        $bestProviders = $em->getRepository("App:Provider")
            ->mostFans(5);

        $recentPromotions = $em->getRepository("App:Promotion")
            ->recentPromotions();

        if(!$services){
            throw new NotFoundHttpException("Aucun service enregistré en DB!");
        }

        return $this->render(
            "superlist/public/service/service-boxed.html.twig",
            array(
                "services"=>$services,
                "recentServices" => $recentServices,
                "serviceCategories" => $serviceCategories,
                "localities" => $localities,
                "bestProviders" => $bestProviders,
                "recentPromotions" => $recentPromotions
            )
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
            'superlist/public/service/service-search-map.html.twig',
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
            "superlist/public/service/service-detail.html.twig",
            array("service"=> $service)
        );
    }

    /**
     * Add service
     *
     * @Route("/profile/stage/new", name="profile_service_add")
     */
    public function addAction(Request $request): Response
    {
        $em = $this->getDoctrine()->getManager();

        $provider = $em->getRepository("App:Provider")
            ->findByToken($request->query->get("token"));

        $form = $this->createForm(ServicesType::class, $provider);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $provider = $form->getData();

            try{

                $em->persist($provider);
                $em->flush();

                $this->addFlash("warning","Erreur dans les données saisies!");

                $this->redirectToRoute("profile_service_list");

            }catch (PersisterException $e){

                $this->addFlash("warning","Erreur dans les données saisies!");

                $this->render(
                    "superlist/profile/service/update.html.twig",
                    array(
                        "form" => $form->createView()
                    )
                );
            }
        }
    }

    /**
     * @Route("/profile/stage/update/{slug}", name="profile_stage_update")
     * @Security("is_granted('ROLE_PROVIDER')")
     * @param Request $request
     * @return Response
     */
    public function updateAction(Request $request): Response
    {
        $em = $this->getDoctrine()->getManager();

        $service = $em->getRepository("App:Service")
            ->find($request->query->get("slug"));

        $form = $this->createForm(ServiceType::class, $service)
            ->setMethod("POST")
            ->setAction($this->generateUrl("service_update"));

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $service = $form->getData();

            try{
                $em->persist($service);

                $em->push();
            }catch (UnexpectedResultException $e){
                $this->addFlash("warning","Impossible d'enregistrer les modifications effectuées!");

                $this->render(
                    "superlist/profile/service/update.html.twig",
                    array("form"=>$form->createView())
                );
            }


            $this->addFlash("success","Mise à jour du stage effectué avec succés!");

            $this->redirectToRoute("profile_service_list");
        }

        $this->render(
            "superlist/profile/service/update.html.twig",
            array(
                "form"=> $form->createView()
            )
        );

    }

}