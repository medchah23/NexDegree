<?php


class matiere{
    private ?int $id_matiere ;
    private ?string $nom;
    private ?string $description;
    private ?int $credit;
    
    private ?int $sems;
    private ?int $niveau;
    private ?string $prerequis;
    private ?int $nombre_chapitre;



    public function __construct( ?int $id_matiere , ?string $nom , ?string $description ,?int $credit , ?int $sems , ?int $niveau, ?string $prerequis, ?int $nombre_chapitre ) 
    {
        $this->id_matiere =$id_matiere ;
        $this->nom=$nom;
        $this->description=$description;
        $this->credit=$credit;
        $this->sems=$sems;
        $this->niveau=$niveau;
        $this->prerequis=$prerequis;
        $this->nombre_chapitre=$nombre_chapitre;
    }

    public function get_id_matiere ():?int{
        return $this->id_matiere ;
    }
    public function set_id_matiere (?int $id_matiere ): void
    {
        $this->id_matiere =$id_matiere ;
    }
    public function get_nom(): ?string
    {
        return $this->nom;
    }
    public function set_nom(?string $nom): void
    {
        $this->nom=$nom;
    }

    public function get_description(): ?string
    {
        return $this->description;
    }

    public function set_description(?string $description): void
    {
        $this->description=$description;
    }
    
    public function get_credit(): ?int
    {
        return $this->credit;
    }
    public function set_credit(?int $credit): void
    {
        $this->credit=$credit;
    }

    public function get_nombre_chapitre(): ?int
    {
        return $this->nombre_chapitre;
    }
    public function set_nombre_chapitre(?int $nombre_chapitre):void
    {
        $this->nombre_chapitre=$nombre_chapitre;
    }
    public function get_sems(): ?int {
        return $this->sems;
    }

    public function set_sems(?int $sems): void {
        $this->sems = $sems;
    }

    public function get_niveau(): ?int {
        return $this->niveau;
    }

    public function set_niveau(?int $niveau): void {
        $this->niveau = $niveau;
    }
    public function get_prerequis(): ?string {
        return $this->prerequis;
    }

    public function set_prerequis(?string $prerequis): void {
        $this->prerequis = $prerequis;
    }

}




?>
