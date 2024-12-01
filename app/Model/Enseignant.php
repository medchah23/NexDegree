<?php

require_once "utilisateur.php";

class Enseignant extends utilisateur
{
    private string $qualifications; // Qualifications of the teacher
    private ?string $cv;            // CV of the teacher (nullable)
    private ?string $image;         // Profile image of the teacher (nullable)

    // Constructor
    public function __construct(
        string $nom,
        string $email,
        string $tel,
        string $mot_de_passe,
        string $role,
        string $statut,
        string $qualifications,
        ?string $cv = null,
        ?string $image = null
    ) {
        parent::__construct($nom, $email, $tel, $mot_de_passe, $role, $statut);
        $this->qualifications = $qualifications;
        $this->cv = $cv;
        $this->image = $image;
    }

    // Getter for image
    public function getImage(): ?string
    {
        return $this->image;
    }

    // Setter for image
    public function setImage(?string $image): void
    {
        $this->image = $image;
    }

    // Getter for CV
    public function getCv(): ?string
    {
        return $this->cv;
    }

    // Setter for CV
    public function setCv(?string $cv): void
    {
        $this->cv = $cv;
    }

    // Getter for qualifications
    public function getQualifications(): string
    {
        return $this->qualifications;
    }

    // Setter for qualifications
    public function setQualifications(string $qualifications): void
    {
        $this->qualifications = $qualifications;
    }
}
?>
