<?php 

class chapitre{
    private ?int $id_chapitre; 
    private ?int $id_matiere;
    private ?string $titre;
    private mixed $contenu;
    private ?string $date_debut;
    private ?int $duree;
    private ?string $objectif;
    private ?string $activite;
    private ?string $res_supp;
    private ?bool $evaluation_incluse;
    private ?string $type_de_evaluation;

    public function __construct(
        ?int $id_chapitre,
        ?int $id_matiere,
        ?string $titre,
        mixed $contenu,
        ?string $date_debut,
        ?int $duree,
        ?string $objectif,
        ?string $activite,
        ?string $res_supp,
        ?bool $evaluation_incluse,
        ?string $type_de_evaluation
    ) {
        $this->id_chapitre = $id_chapitre;
        $this->id_matiere = $id_matiere;
        $this->titre = $titre;
        $this->contenu = $contenu;
        $this->date_debut = $date_debut;
        $this->duree = $duree;
        $this->objectif = $objectif;
        $this->activite = $activite;
        $this->res_supp = $res_supp;
        $this->evaluation_incluse = $evaluation_incluse;
        $this->type_de_evaluation = $type_de_evaluation;
    }


    public function get_id_chapitre(): ?int {
        return $this->id_chapitre;
    }

    public function set_id_chapitre(?int $id_chapitre): void {
        $this->id_chapitre = $id_chapitre;
    }

    public function get_id_matiere(): ?int {
        return $this->id_matiere;
    }

    public function set_id_matiere(?int $id_matiere): void {
        $this->id_matiere = $id_matiere;
    }

    public function get_titre(): ?string {
        return $this->titre;
    }

    public function set_titre(?string $titre): void {
        $this->titre = $titre;
    }

    public function get_contenu(): mixed {
        return $this->contenu;
    }

    public function set_contenu(mixed $contenu): void {
        $this->contenu = $contenu;
    }

    public function get_date_debut(): ?string {
        return $this->date_debut;
    }

    public function set_date_debut(?string $date_debut): void {
        $this->date_debut = $date_debut;
    }

    public function get_duree(): ?int {
        return $this->duree;
    }

    public function set_duree(?int $duree): void {
        $this->duree = $duree;
    }

    public function get_objectif(): ?string {
        return $this->objectif;
    }

    public function set_objectif(?string $objectif): void {
        $this->objectif = $objectif;
    }

    public function get_activite(): ?string {
        return $this->activite;
    }

    public function set_activite(?string $activite): void {
        $this->activite = $activite;
    }

    public function get_res_supp(): ?string {
        return $this->res_supp;
    }

    public function set_res_supp(?string $res_supp): void {
        $this->res_supp = $res_supp;
    }

    public function get_evaluation_incluse(): ?bool {
        return $this->evaluation_incluse;
    }

    public function set_evaluation_incluse(?bool $evaluation_incluse): void {
        $this->evaluation_incluse = $evaluation_incluse;
    }

    public function get_type_de_evaluation(): ?string {
        return $this->type_de_evaluation;
    }

    public function set_type_de_evaluation(?string $type_de_evaluation): void {
        $this->type_de_evaluation = $type_de_evaluation;
    }
}



?>