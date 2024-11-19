<?php

require_once "utilisateur.php";

class Enseignant extends utilisateur
{
    protected string $qualifications; // Qualifications of the teacher
    private mixed $cv;               // CV file (path or content as string)

    // Constructor
    public function __construct(
        string $nom,
        string $email,
        string $tel,
        string $mot_de_passe,
        string $role,
        string $statut,
        mixed $cv,
        string $qualifications
    ) {
        parent::__construct($nom, $email, $tel, $mot_de_passe, $role, $statut);
        $this->cv = $cv;
        $this->qualifications = $qualifications;
    }

    // Getter for CV
    public function getCv(): string
    {
        return $this->cv;
    }

    // Setter for CV
    public function setCv(mixed $cv): void
    {
        $this->cv = $cv;
    }

    // Getter for Qualifications
    public function getQualifications(): string
    {
        return $this->qualifications;
    }

    // Setter for Qualifications
    public function setQualifications(string $qualifications): void
    {
        $this->qualifications = $qualifications;
    }
}
?>
