<?php
/**
 * Created by PhpStorm.
 * User: isk
 * Date: 19.12.17
 * Time: 19:28
 */

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use App\Form\UserType;
use App\Entity\User;

class ProfileController extends Controller
{

    /**
     * @Route("/profile", name="profile_home")
     * @Security("is_granted('ROLE_MEMBER')")
     */
    public function homeAction(Request $request, AuthorizationCheckerInterface $authChecker): Response
    {


        return $this->render(
            "superlist/admin/admin-home.html.twig"
        );
    }



}