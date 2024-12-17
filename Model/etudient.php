<?php


require_once("utilisateur.php");
class Etudiant extends utilisateur
{
    protected string $niveau;
    private ?string $image_profil;

    public function __construct(
        string $nom,
        string $email,
        string $tel,
        string $mot_de_passe,
        string $role,
        string $statut,
        string $niveau,
        mixed $image_profil
    ) {
        parent::__construct($nom, $email, $tel, $mot_de_passe, $role, $statut);
        $this->niveau = $niveau;
        $this->image_profil = $image_profil;
    }

    // Getter for Niveau
    public function getNiveau(): string
    {
        return $this->niveau;
    }

    // Setter for Niveau
    public function setNiveau(string $niveau): void
    {
        $this->niveau = $niveau;
    }

    // Getter for Profile Image
    public function getImageProfil(): mixed
    {
        return $this->image_profil;
    }

    // Setter for Profile Image
    public function setImageProfil(mixed $image_profil): void
    {
        $this->image_profil = $image_profil;
    }
}
?>
