<?php

namespace App\Controller;

use App\Entity\Provider;
use App\Entity\Service;
use App\Form\ServiceType;
use Doctrine\Common\CommonException;
use Doctrine\ORM\EntityNotFoundException;
use Doctrine\ORM\ORMException;
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
     */
    private const LIMIT_PAGINATION = 10;

    /**
     *
     * @Route("/services", name="service_list")
     * @return Response
     */
    public function indexAction(Request $request): Response
    {
        $em = $this->get("doctrine.orm.entity_manager");

        $services = $em->getRepository('App:Service')
            ->myFindAll();

        $paginator = $this->get("knp_paginator");

        $pagination = $paginator->paginate(
            $services,
            $request->query->get("page") ?? 1,  // page demandé
            self::LIMIT_PAGINATION  // nombre d'éléments par page
        );

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
                "services"=>$pagination,
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

        $paginator = $this->get("knp_paginator");

        $pagination = $paginator->paginate(
            $services,
            $request->query->get("page") ?? 1           ,  // page demandé
            self::LIMIT_PAGINATION  // nombre d'éléments par page
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
                "services" => $pagination
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
     * @Route("/profile/stage", name="profile_service_list")
     * @Security("is_granted('ROLE_PROVIDER')", message="Authentification requis!")
     */
    public function listAction(Request $request): Response
    {
        $em = $this->getDoctrine()->getManager();

        $id = $this->getUser()->getId();

        $countServiceCategories = $em->getRepository("App:ServiceCategory")
            ->countByProviderId($id);

        $pendingServices = $em->getRepository("App:Service")
            ->findPendingByProviderId($id);

        $ongoingServices = $em->getRepository("App:Service")
            ->findOngoingByProviderId($id);

        $expiredServices = $em->getRepository("App:Service")
            ->findExpiredByProviderId($id);


        if($countServiceCategories == 0){
            $this->addFlash("warning","Aucune catégories de service enregistré pour vous! \n Commencer par enregistrer les catégories de services pour lesquels vous offrez des services !");
        }

        if(empty($pendingServices)){
            $this->addFlash("warning_pending", "Aucun stage en attente n'est enregistré pour vous");

        }


        if(!$ongoingServices){
            $this->addFlash("warning_ongoing", "Aucun stage en cours n'est enregistré pour vous");

        }

        if(!$expiredServices){
            $this->addFlash("warning_expired", "Aucun stage expiré n'est enregistré pour vous");

        }


        dump($request->getSession()->getFlashBag());

        return $this->render(
            "superlist/profile/service/list.html.twig",
            array(
                "pendingServices" => $pendingServices,
                "ongoingServices" => $ongoingServices,
                "expiredServices" => $expiredServices,
                "user" => $this->getUser()
            )
        );
    }

    /**
     * Add service
     *
     * @Route("/profile/stage/new", name="service_add")
     * @Security("is_granted('ROLE_PROVIDER')", message="Authentification requis!")
     * @param Request $request
     * @return Response
     */
    public function addAction(Request $request): Response
    {
        $em = $this->getDoctrine()->getManager();

        $provider = $this->getUser();

        $service = new Service();

        $form = $this->createForm(ServiceType::class, $service);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $service = $form->getData();

            $service->setProvider($provider);

            try{

                $em->persist($service);
                $em->flush();

                $this->addFlash("warning","Ajout confirmé du service");

                $this->redirectToRoute("profile_service_list");

            }catch (CommonException $e){

                $this->addFlash("warning","Erreur dans les données saisies!");

                $this->redirectToRoute("profile_service_list");
            }
        }

        // Affichage des récents services
        $services = $em->getRepository("App:Service")
            ->findByProviderId($provider->getId());

        if(!$services){
            $this->addFlash("no_services","Aucun service enregistré pour vous!");
        }

        return $this->render(
            "superlist/profile/service/add.html.twig",
            array(
                "form" => $form->createView(),
                "services" => $services,
                "user" => $provider
            )
        );
    }

    /**
     * @Route("/profile/stage/update", name="service_update")
     * @Security("is_granted('ROLE_PROVIDER')", message="Authentification requis!")
     * @param Request $request
     * @return Response
     */
    public function updateAction(Request $request): Response
    {
        $em = $this->getDoctrine()->getManager();

        $service = $em->getRepository("App:Service")
            ->find($request->query->get("id"));

        $form = $this->createForm(ServiceType::class, $service);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $service = $form->getData();

            try{
                $em->persist($service);

                $em->push();

                $this->addFlash("success","Modification enregistré avec succés");

                $this->redirectToRoute("profile_edit_home");

            }catch (UnexpectedResultException $e){

                $this->addFlash("warning","Impossible d'enregistrer les modifications effectuées!");

                $this->redirectToRoute("profile_edit_home");
            }


            $this->addFlash("success","Mise à jour du stage effectué avec succés!");

            $this->redirectToRoute("profile_service_list");
        }

        $services = $em->getRepository("App:Service")
            ->findByProviderId($this->getUser()->getId());

        return $this->render(
            "superlist/profile/service/update.html.twig",
            array(
                "form"=> $form->createView(),
                "user" => $this->getUser(),
                "service" => $service,
                "services" => $services
            )
        );

    }

    /**
     * @Route("/profile/stage/delete", name="service_delete")
     * @Security("is_granted('ROLE_PROVIDER')", message="Authentification requis!")
     * @param Request $request
     * @return Response
     */
    public function deleteAction(Request $request): Response
    {
        $em = $this->getDoctrine()->getManager();

        try{
            $service = $em->getRepository("App:Service")
                ->find($request->query->get("id"));

            $em->remove($service);

            $em->flush();

            $this->addFlash("success", "Suppression du service confirmé!");

        }catch (EntityNotFoundException $e){

            $this->addFlash("warning","Aucun service ne correspond à cette id");
        }catch(ORMException $e){

            $this->addFlash("warning", "Impossible de supprimer ce service!");
        }



        return $this->RedirectToRoute("profile_service_list");
    }


}