<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Table(name="app_users")
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User implements UserInterface, \Serializable, \JsonSerializable {
    /**
     * @ORM\Column(type="guid")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="UUID")
     */
    private $id;

    /**
     * @return mixed
     */
    public function getId() {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id) {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getIsActive() {
        return $this->isActive;
    }

    /**
     * @param mixed $isActive
     */
    public function setIsActive($isActive) {
        $this->isActive = $isActive;
    }

    /**
     * @ORM\Column(type="string", length=25, unique=true)
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=64)
     */
    private $password;

    /**
     * @return mixed
     */
    public function getPlainPassword() {
        return $this->plainPassword;
    }

    /**
     * @param mixed $plainPassword
     */
    public function setPlainPassword($plainPassword) {
        $this->plainPassword = $plainPassword;
    }

    /**
     * @var string
     */
    private $plainPassword;

    /**
     * @ORM\Column(name="is_active", type="boolean")
     */
    private $isActive;

    /**
     * @var string
     * @ORM\Column(name="url", type="string", length=50, unique=true, nullable=true, options={"default":null})
     */
    private $url;

    /**
     * @var string
     * @ORM\Column(name="name", type="string", length=50, nullable=true, options={"default":null})
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ProductsList", mappedBy="user")
     */
    private $lists;

    public function __construct() {
        $this->isActive = true;
        $this->lists =  new ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getLists() {
        return $this->lists;
    }


    public function setLists($lists){
        $this->lists = $lists;
        return $this;
    }

    public function getUsername() {
        return $this->username;
    }

    public function setUsername($username) {
        $this->username = $username;
        return $this;
    }

    public function getSalt() {
        return null;
    }

    public function getPassword() {
        return $this->password;
    }

    public function setPassword($password) {
        $this->password = $password;
        return $this;
    }

    public function getRoles() {
        return array('ROLE_USER', 'ROLE_ADMIN');
    }

    public function eraseCredentials() {
    }

    /**
     * @return string
     */
    public function getUrl(){
        return $this->url;
    }

    /**
     * @param string $url
     * @return User
     */
    public function setUrl(string $url){
        $this->url = $url;
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
     * @return User
     */
    public function setName(string $name){
        $this->name = $name;
        return $this;
    }



    /** @see \Serializable::serialize() */
    public function serialize() {
        return serialize(array(
            $this->id,
            $this->username,
            $this->password
        ));
    }

    /** @see \Serializable::unserialize() */
    public function unserialize($serialized) {
        list (
            $this->id,
            $this->username,
            $this->password
            ) = unserialize($serialized);
    }

    public function jsonSerialize() {
        return [
            "id" => $this->getId(),
            "name"=> $this->getName(),
            "url" => $this->getUrl(),
            "username" => $this->getUsername()
        ];
    }
}