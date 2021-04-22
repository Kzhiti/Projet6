<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

class Comment
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;


    private $user_id;


    private $article_id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Veuillez entrer votre commentaire")
     */
    private $description;

    /**
     * @ORM\Column(type="datetime")
     */
    private $created_at;

    public function getId() {
        return $this->id;
    }

    public function getUserID()
    {
        return $this->user_id;
    }

    public function getArticleID()
    {
        return $this->article_id;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function getDateCreation()
    {
        return $this->created_at;
    }


    public function setUser_id($new_id) {
        $this->user_id = $new_id;
    }

    public function setArticle_id($new_id) {
        $this->article_id = $new_id;
    }

    public function setDescription($new_description)
    {
        $this->description = $new_description;
    }

    public function setCreated_at($new_date)
    {
        $this->created_at = $new_date;
    }
}