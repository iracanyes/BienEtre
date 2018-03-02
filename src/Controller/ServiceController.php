<?php

namespace App\Controller;

use App\Entity\Provider;
use App\Entity\Service;
use App\Form\ServicesType;
use App\Form\ServiceType;
use Doctrine\Common\CommonException;
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
     * @Route("/profile/stages", name="profile_service_list")
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

        // Erreur
        // Vérifiér l'erreur généré par plainPassword null à l'affichage du formulaire
        // empêche la soumission du formulaire
        $provider->setPlainPassword("0");

        dump($provider);

        $form = $this->createForm(ServicesType::class, $provider);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $provider = $form->getData();

            try{

                $em->persist($provider);
                $em->flush();

                $this->addFlash("warning","Erreur dans les données saisies!");

                $this->redirectToRoute("profile_service_list");

            }catch (CommonException $e){

                $this->addFlash("warning","Erreur dans les données saisies!");

                $this->render(
                    "superlist/profile/service/add.html.twig",
                    array(
                        "form" => $form->createView()
                    )
                );
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
     * @Route("/profile/stage/update/{slug}", name="service_update")
     * @Security("is_granted('ROLE_PROVIDER')", message="Authentification requis!")
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