<?php
include "utilisateur.php";
class Enseignant extends Utilisateur {
    protected $qualifications;
    private $cv;
    public function __construct($nom, $email, $mot_de_passe, $role, $statut,$cv,$qualifications)
    {
        parent::__construct($nom, $email, $mot_de_passe, $role, $statut);
        $this->cv = $cv;
        $this->qualifications = $qualifications;

    }
    public function getCv(){
        return $this->cv ;
    }
    public function getQualifications(){
        return $this->qualifications;

    }
    public function setQualifications($qualifications){
        $this->qualifications = $qualifications;
    }
    public function setCv($cv){
        $this->cv = $cv;
    }
}
