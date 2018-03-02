<?php
/**
 * Created by PhpStorm.
 * User: isk
 * Date: 28.02.18
 * Time: 16:32
 */

namespace App\Controller;

use Doctrine\ORM\ORMException;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CommentController extends Controller
{
    /**
     * @Route("/profile/opinions", name="profile_opinion_list")
     * @Security("is_granted('ROLE_PROVIDER')", message="Authentification requis!")
     * @param Request $request
     * @return Response
     */
    public function listAction(Request $request): Response
    {
        $em = $this->getDoctrine()->getManager();

        $user = $this->getUser();

        try{
            $opinions = $em->getRepository("App:Comment")
                ->findByProviderId($user->getId());
        }catch(ORMException $e){
            $this->addFlash("warning", "Une erreur est survenue durant la requête! Ré-essayez");




        }

        if($opinions){
            $this->addFlash("info", "Aucun commentaire trouvé sur vous");
        }


        return $this->render(
            "superlist/profile/opinion/list.html.twig",
            array(
                "user" => $user,
                "opinions" => $opinions
            )
        );

    }
}