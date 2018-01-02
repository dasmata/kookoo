<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Reservation
 *
 * @ORM\Table(name="reservations")
 * @ORM\Entity
 * @package App\Entity
 */
class Reservation {

    /**
     * @ORM\Column(type="guid")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="UUID")
     * @var string
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @var Product
     * @ORM\OneToOne(targetEntity="Product", cascade={"persist", "remove"})
     * @ORM\JoinColumn(name="product_id", referencedColumnName="id", nullable=false)
     */
    private $product;

    /**
     * @return string
     */
    public function getId(){
        return $this->id;
    }

    /**
     * @param string $id
     * @return Reservation
     */
    public function setId(string $id){
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getName(){
        return $this->name;
    }

    /**
     * @param string $name
     * @return Reservation
     */
    public function setName(string $name){
        $this->name = $name;
        return $this;
    }

    /**
     * @return Product
     */
    public function getProduct(){
        return $this->product;
    }

    /**
     * @param Product $product
     * @return Reservation
     */
    public function setProduct($product){
        $this->product = $product;
        return $this;
    }


}