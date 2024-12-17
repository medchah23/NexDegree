<?php


class utilisateur
{

    private ?int $id_utilisateur = null;
    protected string $nom;
    protected string $email;
    private string $tel;
    private string $mot_de_passe;
    public string $role;
    public string $statut;

    // Constructor
    public function __construct(string $nom, string $email, string $tel, string $mot_de_passe, string $role, string $statut)
    {
        $this->nom = $nom;
        $this->email = $email;
        $this->tel = $tel;
        $this->setMotDePasse($mot_de_passe); // Use setter to hash the password
        $this->role = $role;
        $this->statut = $statut;
    }

    // Getters and Setters
    public function getIdUtilisateur(): ?int
    {
        return $this->id_utilisateur;
    }

    public function setIdUtilisateur(int $id_utilisateur): void
    {
        $this->id_utilisateur = $id_utilisateur;
    }

    public function getNom(): string
    {
        return $this->nom;
    }

    public function setNom(string $nom): void
    {
        $this->nom = $nom;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function getTel(): string
    {
        return $this->tel;
    }

    public function setTel(string $tel): void
    {
        $this->tel = $tel;
    }
    public function getMotDePasse(): string
    {
        return $this->mot_de_passe;
    }
    public function setMotDePasse(string $mot_de_passe): void
    {
        $this->mot_de_passe = $mot_de_passe;
    }
    public function verifyMotDePasse(string $mot_de_passe): bool
    {
        return password_verify($mot_de_passe, $this->mot_de_passe);
    }

    public function getRole(): string
    {
        return $this->role;
    }

    public function setRole(string $role): void
    {
        $this->role = $role;
    }

    public function getStatut(): string
    {
        return $this->statut;
    }

    public function setStatut(string $statut): void
    {
        $this->statut = $statut;
    }
}
?>
