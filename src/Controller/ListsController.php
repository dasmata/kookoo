<?php

namespace App\Controller;

use App\Entity\ProductsList;
use App\Form\ProductListType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ArgumentResolver\RequestValueResolver;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncode;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

/**
 * Class ListsController
 * @package App\Controller
 */
class ListsController extends Controller {

    /**
     * @Route(
     *     "/lists",
     *     name="get-all-lists",
     *     methods={"GET"},
     *     options={
     *      "expose"=true,
     *     })
     * @return JsonResponse
     * @param Request $request
     */
    public function getAll(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $lists = $em->getRepository(ProductsList::class)->findBy([
            "user" => $this->get("security.token_storage")->getToken()->getUser()
        ]);

        return new JsonResponse($lists);
    }

    /**
     * @Route(
     *     "/lists/{id}",
     *     name="get-list",
     *     methods={"GET"},
     *     options={
     *      "expose"=true
     *     }
     * )
     * @return JsonResponse
     */
    public function getOne($id) {
        $em = $this->getDoctrine()->getManager();
        $list = $em->getRepository(ProductsList::class)->find($id);

        return new JsonResponse($list);
    }

    /**
     * @Route(
     *     "/lists/{id}",
     *     name="delete-list",
     *     methods={"DELETE"},
     *     options={
     *     }
     * )
     * @return JsonResponse
     */
    public function remove($id) {
        $em = $this->getDoctrine()->getManager();
        $list = $em->getRepository(ProductsList::class)->find($id);

        if($list){
            $em->remove($list);
            $em->flush();
            return new JsonResponse(null, 204);
        }

        return new JsonResponse(null, 404);
    }

    /**
     * @Route(
     *     "/lists",
     *     name="create-list",
     *     methods={"POST"},
     *     options={
     *      "expose"=true,
     *     })
     * @return JsonResponse
     */
    public function create(Request $request) {
        $data = json_decode($request->getContent(), true);
        $em = $this->getDoctrine()->getManager();
        $list = empty($data['id']) ? new ProductsList() : $em->getRepository(ProductsList::class)->find($data['id']);
        $form = $this->createForm(ProductListType::class, $list);
        $data['activeFrom'] = new \DateTime($data['activeFrom']);
        $data['activeUntil'] = new \DateTime($data['activeUntil']);
        $form->submit($data);

        if ($form->isSubmitted() && $form->isValid()) {
            $list->setUser($this->get('security.token_storage')->getToken()->getUser());
            $em->persist($list);
            $em->flush();
            return new JsonResponse($list, 201);
        }

        return new JsonResponse([], 400);
    }
}