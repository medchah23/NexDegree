<?php
class correction {
    private ?int $correctionID;
    private ?int $evaluationID; //L'ID de l'évaluation associée à cette correction.
    private ?bool $disponible;
    private ?float $score;
    private ?string $filePath;  // Chemin du fichier déposé

    // Constructor
    public function __construct(
        ?int $correctionID,
        ?int $evaluationID,
        ?bool $disponible,
        ?float $score,
        ?string $filePath
    ) {
        $this->correctionID = $correctionID;
        $this->evaluationID = $evaluationID;
        $this->disponible = $disponible;
        $this->score = $score;
        $this->filePath = $filePath;
    }

    // Getters and Setters

    public function getCorrectionID(): ?int {
        return $this->correctionID;
    }

    public function setCorrectionID(?int $correctionID): void {
        $this->correctionID = $correctionID;
    }

    public function getEvaluationID(): ?int {
        return $this->evaluationID;
    }

    public function setEvaluationID(?int $evaluationID): void {
        $this->evaluationID = $evaluationID;
    }

    public function isDisponible(): ?bool {
        return $this->disponible;
    }

    public function setDisponible(?bool $disponible): void {
        $this->disponible = $disponible;
    }

    public function getScore(): ?float {
        return $this->score;
    }

    public function setScore(?float $score): void {
        $this->score = $score;
    }

    public function getFilePath(): ?string {
        return $this->filePath;
    }

    public function setFilePath(?string $filePath): void {
        $this->filePath = $filePath;
    }
}
?>
