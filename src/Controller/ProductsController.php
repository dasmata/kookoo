<?php

namespace App\Controller;


use App\Entity\Product;
use App\Entity\ProductsList;
use App\Form\ProductType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ProductsController extends Controller {

    /**
     * @Route(
     *     path="/products",
     *     name="get-list-products",
     *     methods={"GET"},
     *     options={"expose"=true},
     * )
     * @return JsonResponse;
     */
    public function getListProducts(Request $request) {
        $products = $this->getDoctrine()->getRepository(Product::class)->findBy([
            'list' => $request->get('list')
        ]);
        return new JsonResponse($products);
    }

    /**
     * @Route(
     *     path="/products/{id}",
     *     name="get-product",
     *     methods={"GET"},
     *     options={"expose"=true}
     * )
     * @return JsonResponse
     */
    public function getProduct($id) {
        $em = $this->getDoctrine()->getManager();
        $product = $em->getRepository(Product::class)->find($id);
        if ($product) {
            return new JsonResponse($product, 200);
        }
        return new JsonResponse([], 404);
    }


    /**
     * @Route(
     *     path="/products/{id}",
     *     name="delete-product",
     *     methods={"DELETE"},
     * )
     * @return JsonResponse
     */
    public function deleteProduct($id) {
        $em = $this->getDoctrine()->getManager();
        $product = $em->getRepository(Product::class)->find($id);
        if ($product) {
            $em->remove($product);
            $em->flush();
            return new JsonResponse(null, 204);
        }
        return new JsonResponse([], 404);
    }


    /**
     * @Route(
     *     "/products",
     *     name="create-product",
     *     methods={"POST"},
     *     options={
     *      "expose"=true,
     *     })
     * @return JsonResponse
     */
    public function create(Request $request) {
        $data = json_decode($request->getContent(), true);
        $em = $this->getDoctrine()->getManager();
        $product = empty($data['id']) ? new Product() : $em->getRepository(Product::class)->find($data['id']);
        if (empty($product)) {
            return new JsonResponse($product, 404);
        }
        $form = $this->createForm(ProductType::class, $product);
        $form->submit($data);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($product);
            $em->flush();
            return new JsonResponse($product, 200);
        }

        return new JsonResponse([], 400);
    }
}