<?php
class evaluation {
    private ?int $evaluationID;
    private ?string $matiere;
    private ?int $duree;
    private ?float $noteMax;
    private ?DateTime $date2;
    private ?string $description2;


   // private ?bool $correctionDisponible;  Indique si une correction est déjà disponible pour cette évaluation.


   
// Constructor
public function __construct(
    ?int $evaluationID,
    ?string $matiere,
    ?int $duree,
    ?float $noteMax,
    ?DateTime $date2,
    ?string $description2,

) {
    $this->evaluationID = $evaluationID;
    $this->matiere = $matiere;
    $this->duree = ($duree) ;
    $this->noteMax = $noteMax;
    $this->date2 = $date2;
    $this->description2 = $description2;
}
    
    

    // Getters and Setters

    public function getEvaluationID(): ?int {
        return $this->evaluationID;
    }

    public function setEvaluationID(?int $evaluationID): void {
        $this->evaluationID = $evaluationID;
    }

    public function getMatiere(): ?string {
        return $this->matiere;
    }

    public function setMatiere(?string $matiere): void {
        $this->matiere = $matiere;
    }

    public function getDurée(): ?int {
        return $this->duree;
    }

    public function setDurée(?int $duree): void {
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


