<?php
/**
 * Created by PhpStorm.
 * User: tiberiu.popovici
 * Date: 26.12.2017
 * Time: 22:53
 */

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="lists")
 * @ORM\Entity
 */
class ProductsList implements \JsonSerializable {
    /**
     * @ORM\Column(type="guid")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="UUID")
     * @var string
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(type="string", length=100)
     */
    private $name;

    /**
     * @var string
     * @ORM\Column(type="date")
     */
    private $activeFrom;

    /**
     * @var string
     * @ORM\Column(type="date", nullable=true)
     */
    private $activeUntil;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Product", mappedBy="list")
     */
    private $products;

    /**
     * @var User
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="lists", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false, name="user_id", referencedColumnName="id")
     */
    private $user;


    public function __construct() {
        $this->products = new ArrayCollection();
    }

    /**
     * @return Collection|Product[]
     */
    public function getProducts() {
        return $this->products;
    }

    /**
     * @return User
     */
    public function getUser(){
        return $this->user;
    }

    /**
     * @param User $user
     * @return ProductsList
     */
    public function setUser(User $user): ProductsList {
        $this->user = $user;
        return $this;
    }



    /**
     * @return string
     */
    public function getId(){
        return $this->id;
    }

    /**
     * @param string $id
     * @return ProductsList
     */
    public function setId(string $id): ProductsList {
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
     * @return ProductsList
     */
    public function setName(string $name): ProductsList {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getActiveFrom(){
        return $this->activeFrom;
    }

    /**
     * @param \DateTime $activeFrom
     * @return ProductsList
     */
    public function setActiveFrom($activeFrom): ProductsList {
        $this->activeFrom = $activeFrom;
        return $this;
    }

    /**
     * @return string
     */
    public function getActiveUntil(){
        return $this->activeUntil;
    }

    /**
     * @param \DateTime $activeUntil
     * @return ProductsList
     */
    public function setActiveUntil($activeUntil): ProductsList {
        $this->activeUntil = $activeUntil;
        return $this;
    }

    public function jsonSerialize() {
        $until = $this->getActiveUntil();
        return [
            "id" => $this->getId(),
            "name" => $this->getName(),
            "activeFrom" => $this->getActiveFrom()->format("Y-m-d"),
            "activeUntil" => $until ? $until->format("Y-m-d") : null
        ];
    }
}