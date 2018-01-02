<?php
/**
 * Created by PhpStorm.
 * User: tiberiu.popovici
 * Date: 02.01.2018
 * Time: 09:35
 */

namespace App\Controller;


use App\Entity\Product;
use App\Entity\Reservation;
use App\Form\ReservationType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class ReservationsController extends Controller {

    /**
     * @Route(
     *     path="/reservations",
     *     methods={"POST"},
     *     name="create-reservation",
     *     options={
     *         "expose": true
     *     }
     * )
     * @param Request $request
     * @return JsonResponse
     */
    public function create(Request $request) {
        $data = json_decode($request->getContent(), true);
        $reservation = new Reservation();
        $form = $this->createForm(ReservationType::class, $reservation);
        $form->submit($data);
        if($form->isSubmitted() && $form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->persist($reservation);
            $product = $reservation->getProduct();
            $product->setReserved(true);
            $em->persist($product);
            $em->flush();
            return new JsonResponse(null, 201);
        }
        return new JsonResponse(null, 400);
    }


    /**
     * @Route(
     *     path="/reservations/{id}",
     *     methods={"DELETE"},
     *     name="delete-reservation",
     *     options={
     *       "expose": true
     *     }
     * )
     * @param string $id
     * @return JsonResponse
     */
    public function remove($id) {
        $em = $this->getDoctrine()->getManager();
        $reservation = $em->getRepository(Reservation::class)->findBy([
            "product" => $id
        ]);
        if(!count($reservation)){
            return new JsonResponse(null, 404);
        }
        $product = $reservation[0]->getProduct();
        $reservation[0]->setProduct(null);
        $product->setReserved(0);
        $em->remove($reservation[0]);
        $em->persist($product);
        $em->flush();
        return new JsonResponse(null, 204);
    }
}