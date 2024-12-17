<?php

class evaluation {
    private ?int $id;
    private ?string $matiere;
    private ?int $duree;
    private ?float $noteMax;
    private ?DateTime $date2;
    private ?string $quest1;
    private ?string $quest2;
    private ?string $quest3;
    private ?string $quest4;
    private ?string $quest5;
    private ?int $id_chapitre;

    // Constructor
    public function __construct(
        ?int $id, 
        ?string $matiere, 
        ?int $duree, 
        ?float $noteMax, 
        ?DateTime $date2, 
        ?string $quest1, 
        ?string $quest2, 
        ?string $quest3, 
        ?string $quest4, 
        ?string $quest5,
        ?int $id_chapitre
    ) {
        $this->id = $id;
        $this->matiere = $matiere;
        $this->duree = $duree;
        $this->noteMax = $noteMax;
        $this->date2 = $date2;
        $this->quest1 = $quest1;
        $this->quest2 = $quest2;
        $this->quest3 = $quest3;
        $this->quest4 = $quest4;
        $this->quest5 = $quest5;
        $this->id_chapitre = $id_chapitre;
    }

    // Getters and Setters
    public function getId(): ?int {
        return $this->id;
    }

    public function setId(?int $id): void {
        $this->id = $id;
    }

    

    public function getMatiere(): ?string {
        return $this->matiere;
    }

    public function setMatiere(?string $matiere): void {
        $this->matiere = $matiere;
    }

    public function getDuree(): ?int {
        return $this->duree;
    }

    public function setDuree(?int $duree): void {
        $this->duree = $duree;
    }

    public function getNoteMax(): ?float {
        return $this->noteMax;
    }

    public function setNoteMax(?float $noteMax): void {
        $this->noteMax = $noteMax;
    }

    public function getDate2(): ?DateTime {
        return $this->date2;
    }

    public function setDate2(?DateTime $date2): void {
        $this->date2 = $date2;
    }

    public function getQuest1(): ?string {
        return $this->quest1;
    }

    public function setQuest1(?string $quest1): void {
        $this->quest1 = $quest1;
    }

    public function getQuest2(): ?string {
        return $this->quest2;
    }

    public function setQuest2(?string $quest2): void {
        $this->quest2 = $quest2;
    }

    public function getQuest3(): ?string {
        return $this->quest3;
    }

    public function setQuest3(?string $quest3): void {
        $this->quest3 = $quest3;
    }

    public function getQuest4(): ?string {
        return $this->quest4;
    }

    public function setQuest4(?string $quest4): void {
        $this->quest4 = $quest4;
    }

    public function getQuest5(): ?string {
        return $this->quest5;
    }

    public function setQuest5(?string $quest5): void {
        $this->quest5 = $quest5;
    }
    public function getIdChapitre(): ?int {
        return $this->id_chapitre;
    }
    public function setIdChapitre(?int $id_chapitre): void {
        $this->id_chapitre = $id_chapitre;
    }
}

?>

