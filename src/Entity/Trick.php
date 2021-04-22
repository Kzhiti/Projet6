<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

class Trick
{

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;


    private $user_id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="merci de renseigner le titre de la figure")
     */
    private $titre;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="merci de renseigner la description de la figure")
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="merci de renseigner à quel groupe appartient la figure")
     */
    private $groupe;

    /**
     * @ORM\Column(type="datetime")
     */
    private $created_at;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $modified_at;

    public function getId() {
        return $this->id;
    }

    public function getUserID()
    {
        return $this->user_id;
    }

    public function getTitre()
    {
        return $this->titre;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function getGroupe()
    {
        return $this->groupe;
    }

    public function getCreated_at() {
        return $this->created_at;
    }

    public function getModified_at() {
        return $this->modified_at;
    }

    public function setUser_id($new_userid) {
        $this->user_id = $new_userid;
    }

    public function setTitre($new_titre)
    {
        $this->titre = $new_titre;
    }

    public function setDescription($new_description)
    {
        $this->description = $new_description;
    }

    public function setGroupe($new_groupe)
    {
        $this->groupe = $new_groupe;
    }

    public function setCreated_at($new_date) {
        $this->created_at = $new_date;
    }

    public function setModified_at($new_date) {
        $this->modified_at = $new_date;
    }
}