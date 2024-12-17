<?php
include_once(__DIR__ . '/../config.php');
include(__DIR__ . '/../Model/evaluation.php');



class EvaluationController {

    public function listEvaluation($matiere = null) {
        $db = config::getConnexion();
        
        // Construire la requête SQL
        if ($matiere) {
            // Si une matière est fournie, filtrer les tests par matière
            $sql = "SELECT * FROM evaluation WHERE matiere = ?";
            $stmt = $db->prepare($sql);
            $stmt->execute([$matiere]);
        } else {
            // Sinon, récupérer tous les tests
            $sql = "SELECT * FROM evaluation";
            $stmt = $db->query($sql);
        }
    
        try {
            // Retourner les résultats sous forme de tableau
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }
    }

    public function listEvaluationBySubject( $user,$id_chapitre) {
        $db = config::getConnexion();
        $sql = "SELECT * FROM evaluation WHERE  id_chapitre = :id_chapitre AND id
                NOT IN (
                    SELECT id FROM reponse WHERE
                    iduser = :user
                )";
        $stmt = $db->prepare($sql);
        $stmt->execute([
            
            'user' => $user,
            'id_chapitre' => $id_chapitre
        ]);
        try {
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }
    }

    /*fetch() : Récupère une seule ligne du résultat.
    fetchAll() : Récupère toutes les lignes du résultat sous forme de tableau.*/

    public function joinEvaluationReponseClient($user, $id_chapitre) {
        $db = config::getConnexion();
        
        // Corrected SQL query with the proper condition for id_chapitre
        $sql = "SELECT * FROM evaluation e 
                JOIN reponse r ON e.id = r.id
                WHERE r.iduser = :user AND e.id_chapitre = :id_chapitre";
        
        $stmt = $db->prepare($sql);
        
        // Bind the parameters to the query
        $stmt->bindValue(':user', $user);
        $stmt->bindValue(':id_chapitre', $id_chapitre);
        
        try {
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }
    }
    //new one yomken eli foukha zeda
    public function fetchDoneTests($user_id, $id_chapitre, $query) {
        try {
            $db = config::getConnexion();

            // Assuming you have a PDO database connection setup in $this->db
            $stmt = $db->prepare($query);
            $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
            $stmt->bindParam(':id_chapitre', $id_chapitre, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            // Handle any errors
            echo "Error: " . $e->getMessage();
            return [];
        }
    }
//until this 

/*

    public function listEvaluation() {
        $sql = "SELECT * FROM evaluation";
        $db = config::getConnexion();

        try {
            $list = $db->query($sql);
            return $list;
        } 
        catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }
    }*/

    public function addEvaluation($eval) {
        $sql = "INSERT INTO evaluation 
                VALUES (NULL, :matiere, :duree, :noteMax, :date2, :quest1, :quest2, :quest3, :quest4, :quest5, :id_chapitre)";
        $db = config::getConnexion();
        try {
            $query = $db->prepare($sql);
            $query->execute([
                'matiere' => $eval->getMatiere(),
                'duree' => $eval->getDuree(),
                'noteMax' => $eval->getNoteMax(),
                'date2' => $eval->getDate2()->format('Y-m-d'),
                'quest1' => $eval->getQuest1(),
                'quest2' => $eval->getQuest2(),
                'quest3' => $eval->getQuest3(),
                'quest4' => $eval->getQuest4(),
                'quest5' => $eval->getQuest5(),
                'id_chapitre' => $eval->getIdChapitre()
            ]);
        }
        catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }
    }

    public function deleteEvaluation($id) {
        $sql = "DELETE FROM evaluation WHERE id = :id";
        $db = config::getConnexion();
        $query = $db->prepare($sql);
        $query->bindValue(':id', $id);

        try {
            $query->execute();
        } 
        catch (Exception $e) {
            echo 'Erreur : ' . $e->getMessage();
        }
    }

    public function getEvaluation($id) {
        $sql = "SELECT * FROM evaluation WHERE id = $id";
        $db = config::getConnexion();

        try {
            $query = $db->prepare($sql);
            $query->execute();
            $eval = $query->fetch();
            return $eval;
        } 
        catch (Exception $e) {
            echo 'Erreur : ' . $e->getMessage();
        }
    }


    

    // Mettre à jour une évaluation
    public function updateEvaluation($id, $eval) {
        $sql = "UPDATE evaluation SET 
                    matiere = :matiere,
                    duree = :duree,
                    noteMax = :noteMax,
                    date2 = :date2,
                    quest1 = :quest1,
                    quest2 = :quest2,
                    quest3 = :quest3,
                    quest4 = :quest4,
                    quest5 = :quest5
                WHERE id = :id";

        try {
            $db = config::getConnexion();
            $query = $db->prepare($sql);
            $query->execute([
                'id' => $id,
                'matiere' => $eval->getMatiere(),
                'duree' => $eval->getDuree(),
                'noteMax' => $eval->getNoteMax(),
                'date2' => $eval->getDate2()->format('Y-m-d'),
                'quest1' => $eval->getQuest1(),
                'quest2' => $eval->getQuest2(),
                'quest3' => $eval->getQuest3(),
                'quest4' => $eval->getQuest4(),
                'quest5' => $eval->getQuest5()
            ]);
        } 
        catch (PDOException $e) {
            echo "Erreur : " . $e->getMessage();
        }
    }

    public function joinEvaluationResponse($id_evaluation) {
        $sql = "SELECT * FROM evaluation e
                JOIN reponse r on e.id = r.id
                WHERE e.id = :id";
        $db = config::getConnexion();
        $query = $db->prepare($sql);
        try{
            $query->bindValue('id', $id_evaluation);
            $query->execute();
            return $query->fetchAll();
        }catch (Exception $e){
            die($e->getMessage());
        }
    }
}
?>
