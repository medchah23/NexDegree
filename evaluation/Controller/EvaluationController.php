<?php
require_once(__DIR__ . '/../config.php');
include(__DIR__ . '/../Model/evaluation.php'); 



class EvaluationController
{
    public function listEvaluation()
    {
        $sql = "SELECT * FROM evaluation";
        $db = config::getConnexion();
        try {
            $liste = $db->query($sql);
            return $liste;
        } catch (Exception $e) {
            die('Error:' . $e->getMessage());
        }
    }

    function deleteEvaluation($id)
    {
        $sql = "DELETE FROM evaluation WHERE id = :id";
        $db = config::getConnexion();
        $req = $db->prepare($sql);
        $req->bindValue(':id', $id);

        try {
            $req->execute();
        } catch (Exception $e) {
            die('Error:' . $e->getMessage());
        }
    }

    




    public function addEvaluation($matiere, $duree, $noteMax, $date2, $description2) {

        $sql = "INSERT INTO evaluation (matiere, duree, noteMax, date2, description2) VALUES (?, ?, ?, ?, ?)";
        $conn = config::getConnexion();
        try {
            $stmt = $conn->prepare($sql);
            $stmt->execute([$matiere, $duree, $noteMax, $date2->format('Y-m-d'), $description2]);
        } catch (Exception $e) {
            throw new Exception("Error inserting evaluation: " . $e->getMessage());
        }
    }

    



    
function updateEvaluation($evaluation, $id)
{
     var_dump($evaluation);
     //$sql ="UPDATE evaluation where id= $id";

    try {
        $db = config::getConnexion();

        $query = $db->prepare(
            'UPDATE evaluation SET 
                matiere = :matiere,
                duree = :duree,
                noteMax = :noteMax,
                date2 = :date2,
                description2 = :description2
            WHERE evaluationID = :id'
        );

        $query->execute([
            'evaluationID' => $id,
            'matiere' => $evaluation->getMatiere(),
            'duree' => $evaluation->getDurée(),
            'noteMax' => $evaluation->getNoteMax(),
            'date2' => $evaluation->getDate()->format('Y-m-d'),
            'description2' => $evaluation->getDescription()
        ]);
        


        echo $query->rowCount() . " records UPDATED successfully <br>";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage(); 
    }
}

/*
function updateEvaluation($evaluations)
{
    try {
        $db = config::getConnexion();
        $query = $db->prepare(
            'UPDATE evaluation SET 
                matiere = :matiere,
                durée = :durée,
                noteMax = :noteMax,
                date = :date,
                description = :description
            WHERE evaluationID = :id'
        );

        $query->execute([
            'matiere' => $evaluations->getMatiere(),
            'durée' => $evaluations->getDurée(),
            'noteMax' => $evaluations->getNoteMax(),
            'date' => $evaluations->getDate()->format('Y-m-d'),
            'description' => $evaluations->getDescription(),
            'id' => $evaluations->getEvaluationID()
        ]);

        echo $query->rowCount() . " records UPDATED successfully <br>";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}*/








    function showEvaluation($id)
    {
        $sql = "SELECT * from evaluation WHERE evaluationID = $id";
        $db = config::getConnexion();
        try {
            $query = $db->prepare($sql);
            $query->execute();

            $evaluation = $query->fetch();
            return $evaluation;
        } catch (Exception $e) {
            die('Error25: ' . $e->getMessage());
        }
    }
    
}



/*


// Exemple de méthode pour récupérer les tests par matière
 function getTestsBySubject($matiere) {
    $db = config::getConnection(); // Connexion à la base de données

    // Préparer la requête pour filtrer les tests par matière
    $query = "SELECT * FROM evaluation WHERE matiere = :matiere";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':matiere', $matiere, PDO::PARAM_STR);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC); // Retourne les tests disponibles pour cette matière
  }


*/

/*

 function getEvaluationById($evaluationID)
{
    $pdo = config::getConnexion();
    try {
        $query = $pdo->prepare("SELECT * FROM evaluation WHERE evaluationID = :evaluationID");
        $query->execute(['evaluationID' => $evaluationID]);
        return $query->fetch(PDO::FETCH_ASSOC); // Retourne un tableau associatif
    } catch (Exception $e) {
        die('Erreur: ' . $e->getMessage());
    }
}



*/





?>

























