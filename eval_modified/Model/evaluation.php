<?php

class evaluation {
    private ?int $id;
    private ?string $matiere;
    private ?int $duree;
    private ?int $noteMax;
    private ?DateTime $date2;
    private ?string $description2;

    // Constructor
    public function __construct(?int $id, ?string $matiere, ?int $duree, ?int $noteMax, ?DateTime $date2, ?string $description2) {
        $this->id = $id;
        $this->matiere = $matiere;
        $this->duree = $duree;
        $this->noteMax = $noteMax;
        $this->date2 = $date2;
        $this->description2 = $description2;
    }

    // Getters and Setters


    public function getID(): ?int {
        return $this->id;
    }

    public function setEvaluationID(?int $id): void {
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

    public function getDate(): ?DateTime {
        return $this->date2;
    }

    public function setDate(?DateTime $date2): void {
        $this->date2 = $date2;
    }

    public function getDescription(): ?string {
        return $this->description2;
    }

    public function setDescription(?string $description2): void {
        $this->description2 = $description2;
    }
}

?>
