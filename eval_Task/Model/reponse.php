<?php

class reponse {
    private ?int $idrep;
    private ?int $id;//L'ID de l'évaluation associée à cette correction.
    private ?int $iduser;
    private ?string $rep1;
    private ?string $rep2;
    private ?string $rep3;
    private ?string $rep4;
    private ?string $rep5;
    private ?float $note;
    private ?string $remarque;
    private ?bool $statusnote;

    // Constructor
    public function __construct(
        ?int $idrep,
        ?string $rep1, 
        ?string $rep2, 
        ?string $rep3, 
        ?string $rep4, 
        ?string $rep5,
        ?int $id=0 ,
        ?int $iduser=0

    ) {
        $this->idrep = $idrep;
        $this->rep1 = $rep1;
        $this->rep2 = $rep2;
        $this->rep3 = $rep3;
        $this->rep4 = $rep4;
        $this->rep5 = $rep5;
        $this->id = $id;
        $this->iduser = $iduser;

        
    }

    // Getters and Setters
    public function getIdrep(): ?int {
        return $this->idrep;
    }

    public function setIdrep(?int $idrep): void {
        $this->idrep = $idrep;
    }

    public function getId(): ?int {
        return $this->id;
    }

    public function setId(?int $id): void {
        $this->id = $id;
    }

    public function getIduser(): ?int {
        return $this->iduser;
    }

    public function setIduser(?int $iduser): void {
        $this->iduser = $iduser;
    }

    public function getRep1(): ?string {
        return $this->rep1;
    }

    public function setRep1(?string $rep1): void {
        $this->rep1 = $rep1;
    }

    public function getRep2(): ?string {
        return $this->rep2;
    }

    public function setRep2(?string $rep2): void {
        $this->rep2 = $rep2;
    }

    public function getRep3(): ?string {
        return $this->rep3;
    }

    public function setRep3(?string $rep3): void {
        $this->rep3 = $rep3;
    }

    public function getRep4(): ?string {
        return $this->rep4;
    }

    public function setRep4(?string $rep4): void {
        $this->rep4 = $rep4;
    }

    public function getRep5(): ?string {
        return $this->rep5;
    }

    public function setRep5(?string $rep5): void {
        $this->rep5 = $rep5;
    }

    public function getNote(): ?float {
        return $this->note;
    }

    public function setNote(?float $note): void {
        $this->note = $note;
    }

    public function getRemarque(): ?string {
        return $this->remarque;
    }

    public function setRemarque(?string $remarque): void {
        $this->remarque = $remarque;
    }

    public function getStatusnote(): ?bool {
        return $this->statusnote;
    }

    public function setStatusnote(?bool $statusnote): void {
        $this->statusnote = $statusnote;
    }
}

?>
