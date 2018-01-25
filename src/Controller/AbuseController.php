<?php
/**
 * Created by PhpStorm.
 * User: isk
 * Date: 15.01.18
 * Time: 22:52
 */

namespace App\Controller;

use App\Form\AbuseType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Abuse;

class AbuseController extends Controller
{
    /**
     * @Route("/abuse/add", name="abuse_add")
     * @param Request $request
     */
    public function addAction(Request $request)
    {

        $abuse = new Abuse();

        $form = $this->createForm(AbuseType::class, $abuse);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
                $em = $this->getDoctrine()
                ->getManager();

                $em->persist($abuse);

                $em->flush();

                /*
                 * Message de confirmation de l'inscription
                 * raccourci pour $request->getSession()->getFlashBag()->add("type_message", "mon message");
                 */
                $this->addFlash(
                    "notice_success",
                    "Votre plainte a été enregistré. Nous traiterons votre requête rapidement."
                );

        }else{
            $this->addFlash(
                "notice_failure",
                "Erreur lors de la soumission de la plainte!"
            );
        }
    }

}