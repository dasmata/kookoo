<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;


/**
 * Class Product
 * @package App\Entity
 * @ORM\Table(name="products")
 * @ORM\Entity
 */
class Product implements \JsonSerializable {
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
     * @var string
     * @ORM\Column(type="string", length=255)
     */
    private $url;
    /**
     * @var float
     * @ORM\Column(type="decimal", scale=2)
     */
    private $price;

    /**
     * @var integer
     * @ORM\Column(type="integer", length=5, options={"unsigned"=true})
     */
    private $preference;

    /**
     * @var ProductsList
     * @ORM\ManyToOne(targetEntity="App\Entity\ProductsList", inversedBy="products", cascade={"persist", "remove"})
     */
    private $list;

    /**
     * @var boolean
     * @ORM\Column(type="boolean", options={"default"=false})
     */
    private $reserved;


    /**
     * @var Reservation
     * @ORM\OneToOne(targetEntity="Reservation", mappedBy="product")
     */
    private $reservation;

    /**
     * @return string
     */
    public function getId(){
        return $this->id;
    }

    /**
     * @param string $id
     * @return Product
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
     * @return Product
     */
    public function setName(string $name){
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getUrl(){
        return $this->url;
    }

    /**
     * @param string $url
     * @return Product
     */
    public function setUrl(string $url){
        $this->url = $url;
        return $this;
    }

    /**
     * @return float
     */
    public function getPrice(){
        return $this->price;
    }

    /**
     * @param float $price
     * @return Product
     */
    public function setPrice(float $price){
        $this->price = $price;
        return $this;
    }

    /**
     * @return int
     */
    public function getPreference(){
        return $this->preference;
    }

    /**
     * @param int $preference
     * @return Product
     */
    public function setPreference(int $preference){
        $this->preference = $preference;
        return $this;
    }

    /**
     * @return ProductsList
     */
    public function getList(){
        return $this->list;
    }

    /**
     * @param ProductsList $list
     * @return Product
     */
    public function setList($list){
        $this->list = $list;
        return $this;
    }

    /**
     * @return bool
     */
    public function isReserved(){
        return $this->reserved;
    }

    /**
     * @param bool $reserved
     * @return Product
     */
    public function setReserved(bool $reserved): Product {
        $this->reserved = $reserved;
        return $this;
    }


    /**
     * @return Reservation
     */
    public function getReservation(){
        return $this->reservation;
    }

    public function jsonSerialize() {
        $reservation = $this->getReservation();
        return [
            "id" => $this->getId(),
            "name" => $this->getName(),
            "url" => $this->getUrl(),
            "price" => $this->getPrice(),
            "preference" => $this->getPreference(),
            "reserved" => $this->isReserved(),
            "list" => $this->getList()->getId(),
            "reserver" => $reservation ? $reservation->getName() : null
        ];
    }
}