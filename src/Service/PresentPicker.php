<?php

namespace App\Service;


use App\Entity\Product;
use App\Entity\ProductsList;
use App\Entity\User;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class PresentPicker {

    /**
     * @var EntityManagerInterface
     */
    private $em;

    public function __construct(EntityManagerInterface $em) {
        $this->em = $em;
    }

    public function pickPresent($userId, $budget) {
        $user = $this->em->getRepository(User::class)->find($userId);
        if (!$user) {
            throw new NotFoundHttpException();
        }
        $lists = $this->getActiveLists($user);
        if (!count($lists)) {
            return [];
        }

        return $this->getProducts($lists, $this->getMaxBudget($budget));
    }

    private function getMaxBudget($budget){
        $threshold = 500;
        $multiplier = 1 + ($threshold / $budget / 10);
        return $budget * $multiplier;
    }

    private function getActiveLists(User $user) {
        $criteria = new Criteria();
        $activeUntilCriteria = new Criteria();
        $activeUntilCriteria
            ->andWhere($criteria->expr()->gte("activeUntil", new \DateTime()))
            ->orWhere($criteria->expr()->eq("activeUntil", null));
        $criteria
            ->where($criteria->expr()->eq("user", $user))
            ->andWhere($criteria->expr()->lte("activeFrom", new \DateTime()))
            ->andWhere($activeUntilCriteria->getWhereExpression());
        return $this->em->getRepository(ProductsList::class)->matching($criteria)->toArray();
    }

    private function getProducts(array $lists, float $budget) {
        $criteria = new Criteria();
        $criteria
            ->where($criteria->expr()->lte("price", $budget))
            ->andWhere($criteria->expr()->eq("reserved", false))
            ->andWhere($criteria->expr()->in("list", $lists));
        return $this->em->getRepository(Product::class)->matching($criteria)->toArray();
    }
}