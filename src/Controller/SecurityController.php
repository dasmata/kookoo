<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\AuthenticationProviderManager;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;

/**
 * Class SecurityController
 * @package App\Controller
 */
class SecurityController extends Controller {

    /**
     * @return JsonResponse
     * @Route("/login", name="login", options={"expose"=true})
     */
    public function login() {
        return new JsonResponse([]);
    }

    /**
     * @return JsonResponse
     * @Route("/logout", name="logout", options={"expose"=true})
     */
    public function logout() {
        return new JsonResponse([]);
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/register", name="register_form")
     *
     * @param Request $request
     * @param UserPasswordEncoderInterface $passwordEncoder
     */
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder) {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            $password = $passwordEncoder->encodePassword($user, $user->getPlainPassword());
            $user->setPassword($password);

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();


            $token = new UsernamePasswordToken($user, $user->getPlainPassword(), "main", $user->getRoles());
            $this->get("security.token_storage")->setToken($token);

            return $this->redirectToRoute("profile");
        }

        return $this->render("security/register.html.twig", ["form" => $form->createView()]);
    }

}
