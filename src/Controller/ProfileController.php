<?php

namespace App\Controller;

use App\Form\ProfileType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ProfileController extends Controller {

    /**
     * @Route("/profile", name="profile", options={"expose"=true})
     */
    public function index() {
        return $this->render("profile/index.html.twig");
    }

    /**
     * @Route("/update-profile", name="update-profile", options={"expose"=true})
     */
    public function updateProfile(Request $request) {
        $user = $this->get("security.token_storage")->getToken()->getUser();
        $data = json_decode($request->getContent(), true);
        $em = $this->getDoctrine()->getManager();
        $form = $this->createForm(ProfileType::class, $user);
        $form->submit($data);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($user);
            $em->flush();
            return new JsonResponse($user, 200);
        }
        foreach ($form->getErrors() as $error) {
            echo $error->getMessage();
        }
        return new JsonResponse([], 400);
    }


    /**
     * @Route("/get-profile", name="get-profile", options={"expose"=true})
     */
    public function getProfile(Request $request) {
        return new JsonResponse($this->get("security.token_storage")->getToken()->getUser());
    }
}
