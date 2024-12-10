<?php
include_once(__DIR__ . '/../config.php');
include(__DIR__ . '/../Model/reponse.php');

class ReponseController {

    /*public function listReponse($id = null) { 
        $db = config::getConnexion();
        // Construire la requête SQL
        if ($id) {
            // Si un ID est fourni, filtrer les réponses par ID
            $sql = "SELECT * FROM reponse WHERE id = ?";
            $stmt = $db->prepare($sql);
            $stmt->execute([$id]);
        } else {
            // Sinon, récupérer toutes les réponses
            $sql = "SELECT * FROM reponse";
            $stmt = $db->query($sql);
        }
    
        try {
            // Retourner les résultats sous forme de tableau
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }
    }*/

    public function addReponse($reponse) {
        $sql = "INSERT INTO reponse (id,iduser,rep1,rep2,rep3,rep4,rep5) 
        VALUES(:id,:iduser,:rep1,:rep2,:rep3,:rep4,:rep5)";
        $db = config::getConnexion();
        try {
            $query = $db->prepare($sql);
            $query->execute([
                'id' => $reponse->getId(),
                'iduser' => $reponse->getIduser(),
                'rep1' => $reponse->getRep1(),
                'rep2' => $reponse->getRep2(),
                'rep3' => $reponse->getRep3(),
                'rep4' => $reponse->getRep4(),
                'rep5' => $reponse->getRep5()
            ]);
        } 
        catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }
    }

    public function deleteReponse($idrep) {
        $sql = "DELETE FROM reponse WHERE idrep = :idrep";
        $db = config::getConnexion();
        $query = $db->prepare($sql);
        $query->bindValue(':idrep', $idrep);

        try {
            $query->execute();
        } 
        catch (Exception $e) {
            echo 'Erreur : ' . $e->getMessage();
        }
    }

    public function getReponse($idrep) {
        $sql = "SELECT * FROM reponse WHERE idrep = :idrep";
        $db = config::getConnexion();

        try {
            $query = $db->prepare($sql);
            $query->bindValue(':idrep', $idrep);
            $query->execute();
            $reponse = $query->fetch();
            return $reponse;
        } 
        catch (Exception $e) {
            echo 'Erreur : ' . $e->getMessage();
        }
    }
    /*
    public function updateReponse($idrep, $reponse) {
        $sql = "UPDATE reponse SET 
                    id = :id,
                    iduser = :iduser,
                    rep1 = :rep1,
                    rep2 = :rep2,
                    rep3 = :rep3,
                    rep4 = :rep4,
                    rep5 = :rep5,
                    note = :note,
                    remarque = :remarque,
                    statusnote = :statusnote
                WHERE idrep = :idrep";

        try {
            $db = config::getConnexion();
            $query = $db->prepare($sql);
            $query->execute([
                'idrep' => $idrep,
                'id' => $reponse->getId(),
                'iduser' => $reponse->getIduser(),
                'rep1' => $reponse->getRep1(),
                'rep2' => $reponse->getRep2(),
                'rep3' => $reponse->getRep3(),
                'rep4' => $reponse->getRep4(),
                'rep5' => $reponse->getRep5(),
                'note' => $reponse->getNote(),
                'remarque' => $reponse->getRemarque(),
                'statusnote' => $reponse->getStatusnote()
            ]);
        } 
        catch (PDOException $e) {
            echo "Erreur : " . $e->getMessage();
        }
    }*/
    public function updateNote($idrep, $note, $remarque) {
        $sql = "UPDATE reponse SET 
                    note = :note,
                    remarque = :remarque,
                    statusnote = :statusnote
                WHERE idrep = :idrep";
        try {
            $db = config::getConnexion();
            $query = $db->prepare($sql);
            $query->execute([
                'idrep' => $idrep,
                'remarque' => $remarque,
                'statusnote' => true,
                'note' => $note
            ]);
        } 
        catch (PDOException $e) {
            echo "Erreur : " . $e->getMessage();
        }
    }

    public function updateReponse($reponse){
        $sql = "UPDATE reponse SET
                rep1 = :rep1,
                rep2 = :rep2,
                rep3 = :rep3,
                rep4 = :rep4,
                rep5 = :rep5 WHERE idrep = :idrep";
        $db = config::getConnexion();
        $query = $db->prepare($sql);
        try{
            $query->execute([
                'idrep' => $reponse->getIdrep(),
                'rep1' => $reponse->getRep1(),
                'rep2' => $reponse->getRep2(),
                'rep3' => $reponse->getRep3(),
                'rep4' => $reponse->getRep4(),
                'rep5' => $reponse->getRep5()
            ]);
        }catch (Exception $e){
            die($e->getMessage());
        }
    }

    public function qrCodeData($id_evaluation) {
        $sql = "SELECT *, count(r.idrep) as nbr FROM reponse r JOIN evaluation e 
                ON r.id = e.id WHERE e.id = :id_evaluation";
        try{
            $db = config::getConnexion();
            $query = $db->prepare($sql);
            $query->bindValue(':id_evaluation', $id_evaluation);
            $query->execute();
            return $query->fetchAll();
        }catch (Exception $e){
            die($e->getMessage());
        }
    }
}

?>
