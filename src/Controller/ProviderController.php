<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

use App\Entity\Provider;
use App\Form\ProviderType;


/**
 * Description of ProviderController
 *
 */
class ProviderController extends Controller
{
    private const HOME_NUM_RECENT_PROVIDERS = 3;
    private const HOME_NUM_BEST_PROVIDERS = 5;

    /**
     * Route interne /providers
     * 
     * @Route("/providers", name="provider_list")
     *
     */
    public function indexAction(): Response
    {
        $em = $this->get('doctrine.orm.entity_manager');


        $providers = $em->getRepository('App:Provider')
            ->myFindAll();

        /**
         * Widget 1 : Prestataires ajoutés récemment
         */
        $recentProviders = $em->getRepository("App:Provider")
            ->recentProviders(self::HOME_NUM_RECENT_PROVIDERS);

        /**
         * Widget 2 : Filtre
         */
        $serviceCategories = $em->getRepository("App:ServiceCategory")
            ->findAll();
        $localities = $em->getRepository("App:Locality")
            ->findAll();

        /**
         * Widget 3 : Best Providers
         */
        $bestProviders = $em->getRepository("App:Provider")
            ->mostFans(self::HOME_NUM_BEST_PROVIDERS);

        /**
         * Widget 4 : Catégorie
         * Appel dans le widget 3
         */
        if(!$serviceCategories){
            $serviceCategories = $em->getRepository("App:ServiceCategory")
                ->findAll();
        }

        /**
         * Widget 5 : Promotions récentes
         */
        $recentPromotions = $em->getRepository("App:Promotion")
            ->recentPromotionsPlusProviders();


        if(!$providers){
            throw new NotFoundHttpException("Aucun prestataire enregistré!");
        }

        return $this->render(
            'superlist/public/provider/provider-boxed.html.twig',
            array(
                'providers'=> $providers,
                "recentProviders" => $recentProviders,
                "serviceCategories" => $serviceCategories,
                "localities" => $localities,
                "bestProviders" => $bestProviders,
                "recentPromotions" => $recentPromotions
            )
        );
    }  
    


    /**
     * Route /providers/search
     *
     * @Route("/providers/search", name="provider_search")
     */
    public function searchAction(Request $request = null): Response
    {
        /*
         * Récupération des paramètres de recherches
         */
        $criteria = array(
            "locality" => $request->request->get('locality') ?? null,

            "postalCode" => $request->request->get('postalCode') ?? null,

            "township" => $request->request->get('township') ?? null
        );



        $em = $this->get('doctrine.orm.entity_manager');

        /*
         * Récupération de la liste des communes, localités et code postaux pour afficher dans la section de  recherche
         */
        $localities = $em->getRepository('App:Locality')
            ->findAll();
        $townships = $em->getRepository("App:Township")
            ->findAll();
        $postalCodes = $em->getRepository("App:PostalCode")
            ->findAll();



        if($criteria["locality"] !== null || $criteria["postalCode"] !== null || $criteria["township"] !== null){
            $providers = $em->getRepository('App:Provider')
                ->searchBy($criteria);
        }else{
            $providers = $em ->getRepository("App:Provider")
                ->myFindAll();
        }

        dump($providers);

        if(!$providers){
            throw $this->createNotFoundException("Aucun provider n\'a été trouvé avec les critères suivants : \n Localité : ".$criteria["locality"]."\n Code postal : ".$criteria["postalCode"]."\n Ville : ".$criteria["township"]);
        }

        return $this->render(
            'superlist/public/provider/provider-search-map.html.twig',
            array(
                "providers" => $providers,
                "localities" => $localities,
                "postalCodes" => $postalCodes,
                "townships" => $townships
            )
        );
    }

    /**
     * Route /providers/[slug]
     *
     * @Route("/providers/{slug}", name="provider_detail")
     */
    public function showAction(Request $request): Response
    {
        $em = $this->get("doctrine.orm.entity_manager");

        $slug = $request->attributes->get("slug") ? $request->attributes->get("slug") : null;

        if($slug){
            $provider = $em->getRepository('App:Provider')
                ->findOneBySlug($slug);
        }


        $recentProviders = $em->getRepository("App:Provider")
            ->recentProviders(self::HOME_NUM_RECENT_PROVIDERS);

        if(!$provider){
            throw new NotFoundHttpException("Le prestataire ".$slug." n'existe pas");
        }

        if(!$recentProviders){
            throw $this->createNotFoundException("Pas prestataires récents!");
        }

        return $this->render(
            "superlist/public/provider/provider-listing-detail.html.twig",
            array(
                "provider"=>$provider,
                "recentProviders" => $recentProviders
            )
        );
    }

    /**
     *
     */
    public function getMoyenVotes(Request $request): string
    {
        $provider = $this->request->get('provider');

        $vote = new Vote($provider);

        $moyen = $vote->calcMoyen();

        return $vote->getStars($moyen);
    }

    /**
     * @Route("/profile/update", name="provider_update")
     * @ Security("is_granted('ROLE_PROVIDER')")
     * @param Request $request
     * @return Response
     */
    public function updateAction(Request $request, AuthorizationCheckerInterface $authChecker): Response
    {
        /* Accès autorisé aux utilisation ayant le rôle ROLE_PROVIDER
        if(false === $authChecker->isGranted('ROLE_PROVIDER') && $request->query->get('token')){
            return $this->redirectToRoute('login');
        }
        */
        // Entity manager
        $em = $this->getDoctrine()->getManager();

        // Id du provider
        $token = $request->query->get("token");

        // Chargement du prestataire
        $provider = $em->getRepository("App:Provider")
            ->findOneByToken($token);

        dump($provider);

        //Création du formulaire à partir du FormBuilder
        $form= $this->createForm(ProviderType::class, $provider)
            ->setAction($this->generateUrl('provider_update'))
            ->setMethod('POST');



        //hydratation de l'objet avec les données de la requête
        $form->handleRequest($request);

        //Gestion de la soumission du formulaire
        // Si le formulaire est soumis et que les données sont valides
        if($form->isSubmitted() && $form->isValid()){

            $provider = $form->getData();
            //Si $provider n'est pas hydraté, on peut essayer de récupèrer les données du formulaire
            // $provider = $form->getData()
            $em->persist($provider);
            $em->flush();

            return $this->redirectToRoute('profile_home');
        }



        // On retourne la vue du formulaire avec "$form->createView()
        // dans notre réponse HTML retourné par "$this->render()

        return $this->render(
            "superlist/profile/provider/update.html.twig",
            array("form" => $form->createView())
        );



    }




}
