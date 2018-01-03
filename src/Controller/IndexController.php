<?php

namespace App\Controller;

use App\Entity\User;
use App\Service\PresentPicker;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class IndexController
 * @package App\Controller
 */
class IndexController extends Controller {

    public function index(Request $request, AuthenticationUtils $authUtils) {
        // get the login error if there is one
        $error = $authUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authUtils->getLastUsername();

        $token = $this->get("security.token_storage")->getToken();
        $user = $token ? $token->getUser() : null;
        if ($user && $user !== 'anon.') {
            return new RedirectResponse($this->generateUrl("profile"));
        }

        return $this->render("home/content.html.twig", array(
            'last_username' => $lastUsername,
            'error' => $error
        ));
    }

    /**
     * @Route(
     *     path="/check-url",
     *     name="check-url",
     *     options={
     *      "expose":true
     *     }
     * )
     * @param Request $request
     */
    public function checkUrl(Request $request) {
        $url = $request->get('url');
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository(User::class)->findBy(
            [
                'url' => $url
            ]
        );
        $count = count($user);
        if ($count && $user[0]->getId() === $this->get("security.token_storage")->getToken()->getUser()->getId()) {
            $count = 0;
        }
        $url .= $count === 0 ? "" : $count;
        return new JsonResponse(["url" => $url], 200);
    }

    /**
     * @Route(
     *     path="/pick-present",
     *     name="pick-present",
     *     options={
     *      "expose":true
     *     }
     * )
     * @param Request $request
     * @param PresentPicker $picker
     */
    public function pickPresent(Request $request, PresentPicker $picker) {
        $user = $request->get("user");
        $budget = $request->get("budget");
        return new JsonResponse($picker->pickPresent($user, $budget));
    }

    /**
     * @Route(
     *     path="/{urlPath}",
     *     name="picker",
     *     requirements={"urlPath": "^(?!admin|login|logout|js|_wdt).+"},
     *     options={
     *      "expose":true
     *     }
     * )
     * @param Request $request
     */
    public function picker($urlPath) {
        $user = $this->getDoctrine()->getManager()->getRepository(User::class)->findBy([
            "url" => $urlPath
        ]);
        if (count($user) === 0) {
            throw new NotFoundHttpException();
        }
        return $this->render("home/picker.html.twig", [
            "requestedUser" => $user[0]
        ]);
    }
}