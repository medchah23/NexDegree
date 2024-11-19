<?php
include "utilisateur.php";

class Etudiant extends Utilisateur
{
    protected $niveau;
    private $image_profil;
    public function __construct($nom, $email, $mot_de_passe, $role, $statut, $niveau, $image_profil)
    {
        parent::__construct($nom, $email, $mot_de_passe, $role, $statut);
        $this->niveau = $niveau;
        $this->image_profil = $image_profil;
    }

    public function getNiveau()
    {
        return $this->niveau;
    }

    public function setNiveau($niveau)
    {
        $this->niveau = $niveau;
    }

    // Getters et setters pour l'image de profil
    public function getImageProfil()
    {
        return $this->image_profil;
    }

    public function setImageProfil($image_profil)
    {
        $this->image_profil = $image_profil;
    }
}
?>
