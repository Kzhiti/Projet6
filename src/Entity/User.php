<?php


namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

class User
{

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="merci de renseigner votre pseudo")
     */
    private $pseudo;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(min=8, minMessage="Le mot de passe ne peut pas faire moins de 8 caracteres")
     */
    private $password;

    /**
     * @Assert\EqualTo(propertyPath="password", message="Les mots de passe doivent être identiques")
     */
    private $password_confirm;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date_creation;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="merci de renseigner votre nom")
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="merci de renseigner votre prenom")
     */
    private $prenom;

    public function getId() {
        return $this->id;
    }

    public function getPseudo()
    {
        return $this->pseudo;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function getPassword_confirm()
    {
        return $this->password_confirm;
    }

    public function getDateCreation()
    {
        return $this->date_creation;
    }

    public function getNom() {
        return $this->nom;
    }

    public function getPrenom() {
        return $this->prenom;
    }

    public function setPseudo($new_pseudo)
    {
        $this->pseudo = $new_pseudo;
    }


    public function setPassword($new_password)
    {
        $this->password = $new_password;
    }

    public function setPassword_confirm($new_password)
    {
        $this->password_confirm = $new_password;
    }


    public function setDate_creation($new_date)
    {
        $this->date_creation = $new_date;
    }

    public function setNom($new_nom) {
        $this->nom = $new_nom;
    }

    public function setPrenom($new_prenom) {
        $this->prenom = $new_prenom;
    }
}